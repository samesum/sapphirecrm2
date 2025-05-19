<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Addon_hook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Validator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;



class AddonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->addon_server_side($request->customSearch);
        }
        $page_data['addons'] = Addon::get();
        return view('addon.index', $page_data);
    }

    public function add()
    {
        return view('addon.add');
    }

    private function createDirectoryIfNotExists($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'type' => 'required|in:install,update',
            'file' => 'required|mimes:zip|max:10240', // Ensure the file is a ZIP file and max size is 10MB
        ]);
        $purchase_code = null;
        // Verify purchase code for non-localhost
        if ($_SERVER['SERVER_NAME'] !== 'localhost' && $_SERVER['SERVER_NAME'] !== '127.0.0.1') {
            $purchase_code = $request->code;
            $status_response = $this->verify_purchase_code($purchase_code);

            if (!$status_response) {
                Session::flash('error', get_phrase('purchase_code_is_wrong'));
                return redirect()->back();
            }
        }

        if ($request->type == 'install') {
            // Handle uploaded file
            $uploadedFile = $request->file('file');
            $zipped_file_name = $uploadedFile->getClientOriginalName();
            $dir = 'app/Addons';
            $this->createDirectoryIfNotExists($dir);
            $path = $dir . '/' . $zipped_file_name;
            $uploadedFile->move($dir, $zipped_file_name);

            if (class_exists('ZipArchive')) {
                $zip = new \ZipArchive;
                if ($zip->open($path) === TRUE) {
                    $zip->extractTo($dir);
                    $zip->close();
                    unlink($path);
                } else {
                    Session::flash('error', get_phrase('failed to open the zip file'));
                    return redirect()->back();
                }
            } else {
                Session::flash('error', get_phrase('your server is unable to extract the zip file') . '. ' . get_phrase('please enable the zip extension on your server') . ', ' . get_phrase('then try again'));
                return redirect()->back();
            }

            $unzipped_file_name = pathinfo($zipped_file_name, PATHINFO_FILENAME);
            $addon_path = $dir . '/' . $unzipped_file_name;
            $config_path = $addon_path . '/config.json';
            $installer_migration_path = $addon_path . '/migrations/install.php';
            $updater_migration_path = $addon_path . '/migrations/update.php';
            $config_str = file_get_contents($config_path);
            $config = json_decode($config_str, true);


            //Database migration
            $updater_migration_content = file_get_contents($updater_migration_path);
            $installer_migration_content = file_get_contents($installer_migration_path);

            if ($updater_migration_content) {
                eval($updater_migration_content);
            } elseif ($installer_migration_content) {
                eval($installer_migration_content);
            }


            // Insert or update the addon in the database
            $data = [
                'name' => $config['name'],
                'unique_identifier' => $config['unique_identifier'],
                'version' => $config['version'],
                'about' => $config['about'],
                'status' => 1,
            ];

            $addon_details = Addon::where('unique_identifier', $config['unique_identifier']);
            if ($addon_details->exists()) {
                $data['updated_at'] = Carbon::now();
                $addon_details->update($data);
                $addon = $addon_details->first();
            } else {
                $data['purchase_code'] = $purchase_code;
                $data['created_at'] = Carbon::now();
                $addon = Addon::insert($data);
            }

            // After insertion or update, install will be the addon model instance
            if (isset($addon) && $addon) {
                // Insert hooks for the addon
                foreach ($config['addon_hooks'] as $key => $hook) {
                    $dom = [
                        'parent' => $hook['parent'],
                        'position' => $hook['position']
                    ];
                    $hook_data = [
                        'addon_id' => $addon_details->first()->id,
                        'app_route' => $hook['app_route'],
                        'addon_route' => $hook['addon_route'],
                        'dom' => json_encode($dom)
                    ];
                    // Check if hook already exists
                    $hook_data['updated_at'] = Carbon::now();
                    $existingHook = Addon_hook::where('addon_id', $addon_details->first()->id)->where('app_route', $hook['app_route'])->where('updated_at', '!=', $hook_data['updated_at'])->first();

                    if ($existingHook) {
                        $existingHook->update($hook_data);
                    } else {
                        $hook_data['created_at'] = Carbon::now();
                        Addon_hook::insert($hook_data);
                    }
                }
            }

            // Clean up temporary files
            Session::flash('success', get_phrase('Addon installed'));
            return redirect()->back();
        }

        Session::flash('error', get_phrase('No addon found'));
        return redirect()->back();
    }

    public function status($id)
    {
        $addon = Addon::where('id', $id)->first();
        if ($addon->status) {
            $addon->status = 0;
            $addon->save();
            return response()->json([
                'success' => get_phrase('Addon disabled'),
            ]);
        } else {
            $addon->status = 1;
            $addon->save();
            return response()->json([
                'success' => get_phrase('Addon activated'),
            ]);
        }
    }

    public function edit($id)
    {
        $page_data['addon'] = Addon::where('id', $id)->first();
        return view('addon.edit', $page_data);
    }

    public function delete($id)
    {
        $addon = Addon::where('id', $id);
        $path = 'app/Addons/' . $addon->value('unique_identifier');
        if ($addon->delete()) {
            if (File::exists($path) && File::isDirectory($path)) {
                File::deleteDirectory($path);
            }
            $addon_hooks = Addon_hook::where('addon_id', $id);
            if (count($addon_hooks->get()) > 0) {
                $addon_hooks->delete();
            }
            Session::flash('success', get_phrase('Addon deleted'));
        } else {
            Session::flash('error', get_phrase('Addon delete fail'));
        }
        return redirect()->back();
    }


    public function verify_purchase_code($code)
    {
        $purchase_code = $code;

        $personal_token = "FkA9UyDiQT0YiKwYLK3ghyFNRVV9SeUn";
        $url = "https://api.envato.com/v3/market/author/sale?code=" . $purchase_code;
        $curl = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $purchase_code . '.json';
        $ch_verify = curl_init($verify_url . '?code=' . $purchase_code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($cinit_verify_data, true);

        if (count($response['verify-purchase']) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function exportFile(Request $request, $file)
    {

        $query = Addon::query();

        $ids = $request->input('selectedIds'); // e.g. "[1,2,3]"
        if (!empty($ids) && $ids != '[]') {
            $idsArray = json_decode($ids, true); // convert to array
            if (is_array($idsArray)) {
                $query->whereIn('id', $idsArray);
            }
        }


        if ($file == 'pdf') {
            $page_data['addons'] = count($request->all()) > 0 ? $query->get() : Addon::get();
            $pdf = FacadePdf::loadView('addon.pdf', $page_data);
            return $pdf->download('addon.pdf');
        }

        if ($file == 'print') {
            $page_data['addons'] = count($request->all()) > 0 ? $query->get() : Addon::get();
            $pdf = FacadePdf::loadView('addon.pdf', $page_data);
            return $pdf->stream('addon.pdf');
        }

        if ($file == 'csv') {
            $fileName = 'addon.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            // Use the filtered query to get the projects for CSV
            $users = count($request->all()) > 0 ? $query->get() : Addon::all();

            $columns = ['#', 'name', 'identifier', 'version', 'status', 'about'];

            $callback = function () use ($columns, $users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                $count = 1;
                foreach ($users as $item) {
                    fputcsv($file, [
                        $count,
                        $item->name,
                        $item->unique_identifier,
                        $item->version,
                        $item->status == 1 ? 'Active' : 'Deactive',
                        $item->about
                    ]);
                    $count++;
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // If no valid file type was provided
        return response()->json(['error' => 'Invalid file type'], 400);
    }
}
