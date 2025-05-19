<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Invoice;
use App\Models\Meeting;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    private $code;
    private $project;
    public function __construct()
    {
        $this->code    = request()->route()->parameter('code');
        $this->project = Project::where('code', $this->code)->first();
    }

    public function index(Request $request, $layout = "")
    {
        $user                   = Auth::user();
        $page_data['layout']    = $layout;
        $page_data['page_item'] = 12;

        if ($request->ajax() && $layout == 'grid') {
            $pagination = $request->page_item ?? $page_data['page_item'];
            $filter_count = [];
            if ($request) {
                $projects     = Project::query();

                if ($request->customSearch) {
                    $projects = Project::where('title', 'like', '%' . $request->customSearch . '%');
                }

                if ($request->category && $request->category != 'all') {
                    $filter_count[] = $request->category;
                    $projects       = $projects->where('category_id', $request->category);
                }

                if ($request->status && $request->status != 'all') {
                    $filter_count[] = $request->status;
                    $projects       = $projects->where('status', $request->status);
                }

                if ($request->client && $request->client != 'all' || auth()->user()->role_id == 2) {
                    if (auth()->user()->role_id == 2) {
                        $client = auth()->user()->id;
                    } else {
                        $client = $request->client;
                        $filter_count[] = $client;
                    }

                    $projects       = $projects->where('client_id', $client);
                }

                if ($request->staff && $request->staff != 'all' || auth()->user()->role_id == 3) {
                    if (auth()->user()->role_id == 3) {
                        $staff = [auth()->user()->id];
                    } else {
                        $staff = $request->staff;
                        $filter_count[] = $staff;
                    }

                    $staff          = json_encode($staff);
                    $staff          = str_replace('[', '', $staff);
                    $staff          = str_replace(']', '', $staff);
                    $projects       = $projects->where('staffs', 'like', '%' . $staff . '%');
                }

                $maxPrice = (int) str_replace('$', '', $request->maxPrice);
                $minPrice = (int) str_replace('$', '', $request->minPrice);
                if ($minPrice > 0 && is_numeric($minPrice) && is_numeric($maxPrice)) {
                    $filter_count[] = $minPrice ?? $maxPrice;
                    $projects->whereBetween('budget', [$minPrice, $maxPrice]);
                }

                $page_data['projects']     = $projects->paginate($pagination);
                $page_data['filter_count'] = count($filter_count);
                $page_data['search']       = $request->customSearch;
            } else {
                if (auth()->user()->role_id == 2) {
                    $client = auth()->user()->id;
                    $filter_count[] = $client;
                    $projects       = $projects->where('client_id', $client);
                }

                if (auth()->user()->role_id == 3) {
                    $staff = [auth()->user()->id];

                    $filter_count[] = $staff;
                    $staff          = json_encode($staff);
                    $staff          = str_replace('[', '', $staff);
                    $staff          = str_replace(']', '', $staff);
                    $projects       = $projects->where('staffs', 'like', '%' . $staff . '%');
                }

                $page_data['filter_count'] = count($filter_count);
                $page_data['projects'] = Project::paginate($pagination);
            }

            return view('projects.ajax_grid', $page_data);
        } elseif ($request->ajax()) {
            return app(ServerSideDataController::class)->project_server_side($request->customSearch, $request->category, $request->status, $request->client, $request->staff, str_replace('$', '', $request->minPrice), str_replace('$', '', $request->maxPrice));
        }


        if (get_current_user_role() == 'client') {
            $page_data['projects'] = Project::with('user')->where('client_id', $user->id)->paginate(12);
        } elseif (get_current_user_role() == 'staff') {
            $page_data['projects'] = Project::with('user')->whereJsonContains('staffs', (string) $user->id)->paginate(12);
        } else {
            $page_data['projects'] = Project::with('user')->paginate(12);
        }

        $page_data['clients']    = User::where('role_id', 2)->get();
        $page_data['staffs']     = User::where('role_id', 3)->get();
        $page_data['categories'] = Category::where('parent', '!=', 0)->get();

        return view('projects.index', $page_data);
    }

    public function show()
    {

        $page_data['files']      = File::where('project_id', $this->project->id)->get();
        $page_data['milestones'] = Milestone::where('project_id', $this->project->id)->get();
        $page_data['timesheets'] = Timesheet::where('project_id', $this->project->id)->get();
        $page_data['tasks']      = Task::where('project_id', $this->project->id)->get();
        $page_data['meetings']   = Meeting::where('project_id', $this->project->id)->get();
        $page_data['invoices']   = Invoice::where('project_id', $this->project->id)->get();

        $project_status = ['completed', 'in_progress', 'not_started'];
        $status         = collect($project_status)->map(function ($status) {
            return [
                'title'  => ucwords(str_replace('_', ' ', $status)),
                'amount' => Task::where('project_id', $this->project->id)->where('status', $status)->count(),
            ];
        });
        $page_data['project_status'] = $status;

        $page_data['users']  = User::get();
        $page_data['team']   = Project::where('id', $this->project->id)->first();
        $page_data['staffs'] = json_decode($page_data['team']->staffs) ?? [];

        return view('projects.details', $page_data);
    }

    public function create()
    {
        $page_data['categories'] = Category::where('parent', '!=', 0)->get();
        $page_data['projects']   = Project::get();
        $client                  = Role::where('title', 'client')->first();
        $page_data['clients']    = User::where('role_id', $client->id)->get();
        $staffs                  = Role::where('title', 'staff')->first();
        $page_data['staffs']     = User::where('role_id', $staffs->id)->get();

        return view('projects.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'code'        => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'client_id'   => 'required|integer',
            'staffs'      => 'required|array',
            'budget'      => 'required|numeric',
            'status'      => 'required|string|max:255',
            'note'        => 'required|string',
            'privacy'     => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $project['title']           = $request->title;
        $project['code']            = $this->product_code_elegibility($request->code);
        $project['description']     = $request->description;
        $project['category_id']     = $request->category_id;

        if (auth()->user()->role_id == 2) {
            $project['client_id']       = auth()->user()->id;
        } else {
            $project['client_id']       = $request->client_id;
        }

        if (auth()->user()->role_id == 1) {
            $project['staffs']          = json_encode($request->staffs);
        } elseif (auth()->user()->role_id == 3) {
            $project['staffs']          = json_encode([auth()->user()->id]);
        } else {
            $project['staffs']          = json_encode([]);
        }

        $project['budget']          = $request->budget;
        $project['progress']        = $request->progress;
        $project['status']          = $request->status;
        $project['note']            = $request->note;
        $project['privacy']         = $request->privacy;
        $project['timestamp_start'] = date('Y-m-d', time());
        $project['timestamp_end']   = date('Y-m-d', time());

        Project::insert($project);

        return response()->json([
            'success' => 'Product Created.',
        ]);
    }





    function product_code_elegibility($code, $except_id = null)
    {
        $updated_code = $code;
        $counter = 1;

        while (Project::where('code', $code)
            ->when($except_id, function ($query) use ($except_id) {
                return $query->where('id', '!=', $except_id);
            })
            ->exists()
        ) {
            $updated_code = random(8);
            $counter++;
        }

        return strtoupper($updated_code);
    }

    public function delete()
    {
        Project::find($this->project->id)->delete();
        return response()->json([
            'success' => 'Product Deleted.',
        ]);
    }

    public function edit($code)
    {
        $project['project']    = Project::where('code', $code)->first();
        $project['categories'] = Category::where('parent', '!=', 0)->get();
        $client                = Role::where('title', 'client')->first();
        $project['clients']    = User::where('role_id', $client->id)->get();

        $staffs            = Role::where('title', 'staff')->first();
        $project['staffs'] = User::where('role_id', $staffs->id)->get();

        return view('projects.edit', $project);
    }

    public function update(Request $request, $code)
    {
        $project['title']           = $request->title;
        $project['description']     = $request->description;
        $project['category_id']     = $request->category_id;

        if (auth()->user()->role_id != 2) {
            $project['client_id']       = $request->client_id;
        }

        if (auth()->user()->role_id == 1) {
            $project['staffs']          = json_encode($request->staffs);
        }

        $project['budget']          = $request->budget;
        $project['progress']        = $request->progress;
        $project['status']          = $request->status;
        $project['note']            = $request->note;
        $project['privacy']         = $request->privacy;
        $project['timestamp_start'] = date('Y-m-d H:i:s', time());
        $project['timestamp_end']   = date('Y-m-d H:i:s', time());

        Project::where('code', $code)->update($project);

        return response()->json([
            'success' => 'Product Updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids   = $request->ids;
        $model = 'App\\Models\\' . ucwords($request->type);
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $model::where('id', $id)->delete();
            }
            return response()->json(['success' => get_phrase(ucwords($request->type) . ' ' . "Projects Deleted.")]);
        }
        return response()->json(['error' => get_phrase('No users selected for deletion.')], 400);
    }

    public function categories(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->category_server_side($request->customSearch, $request->category, $request->status, $request->client, $request->staff, $request->minPrice, $request->maxPrice);
        }
        $page_data['categories'] = Category::get();
        return view('projects.category.index', $page_data);
    }

    public function category_create()
    {
        $page_data['categories'] = Category::where('parent', 0)->get();
        return view('projects.category.create', $page_data);
    }

    public function category_store(Request $request, $id = "")
    {
        $data['name']       = $request->name;
        $data['parent']     = $request->parent ?? 0;
        $data['status']     = $request->status;
        $data['created_at'] = Carbon::now();
        if ($id) {
            $data['updated_at'] = Carbon::now();
            Category::where('id', $id)->update($data);
        } else {
            Category::insert($data);
        }
        return response()->json(['success' => 'Category ' . ($id ? 'Updated.' : 'Created.')]);
    }

    public function category_delete($id)
    {
        Category::where('id', $id)->delete();
        return response()->json(['success' => 'Category Deleted.']);
    }

    public function category_edit($id)
    {
        $page_data['categories'] = Category::where('parent', 0)->get();
        $page_data['category']   = Category::where('id', $id)->first();
        return view('projects.category.edit', $page_data);
    }

    public function exportFile(Request $request, $file)
    {
        // Build the query based on the filters
        $query = Project::query();

        $ids = $request->input('selectedIds'); // e.g. "[1,2,3]"
        if (!empty($ids) && $ids != '[]') {
            $idsArray = json_decode($ids, true); // convert to array
            if (is_array($idsArray)) {
                $query->whereIn('id', $idsArray);
            }
        }

        $user = Auth::user();
        if (get_current_user_role() == 'client') {
            $query->where('client_id', $user->id);
        } elseif (get_current_user_role() == 'staff') {
            $query->whereJsonContains('staffs', (string) $user->id);
        }

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%")
                    ->orWhere('code', 'like', "%{$string}%")
                    ->orWhereHas('user', function ($userQuery) use ($string) {
                        $userQuery->where('name', 'like', "%{$string}%");
                    });
            });
        }

        // Apply category filter
        if ($request->category && $request->category != 'all') {
            $query = $query->where('category_id', $request->category);
        }

        // Apply status filter
        if ($request->status && $request->status != 'all') {
            $query = $query->where('status', $request->status);
        }

        // Apply client filter
        if ($request->client && $request->client != 'all') {
            $query = $query->where('client_id', $request->client);
        }

        // Apply staff filter
        if ($request->staff && $request->staff != 'all') {
            $staff = json_decode($request->staff, true); // Decode the staff JSON
            if (!empty($staff) && is_array($staff)) {
                foreach ($staff as $staffId) {
                    $query = $query->where('staffs', 'like', "%$staffId%");
                }
            }
        }

        // Apply price filter
        if ($request->maxPrice && $request->minPrice) {
            $maxPrice = (int) str_replace('$', '', $request->maxPrice);
            $minPrice = (int) str_replace('$', '', $request->minPrice);
            if ($minPrice > 0 && $maxPrice > 0) {
                $query = $query->whereBetween('budget', [$minPrice, $maxPrice]);
            }
        }


        // Check the file type and generate the appropriate response
        $page_data['projects'] = (count($request->all()) > 0 || get_current_user_role() != 'admin') ? $query->get() : Project::get();

        if ($file == 'pdf') {
            $pdf = FacadePdf::loadView('projects.pdf', $page_data);
            return $pdf->download('projects.pdf');
        }
        if ($file == 'print') {
            $pdf = FacadePdf::loadView('projects.pdf', $page_data);
            return $pdf->stream('projects.pdf');
        }

        if ($file == 'csv') {
            $fileName = 'projects.csv';
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            // Use the filtered query to get the projects for CSV
            $projects = (count($request->all()) > 0 || get_current_user_role() != 'admin') ? $query->get() : Project::all();

            $columns = ['#', 'Title', 'Code', 'Client', 'Staff', 'Budget', 'Progress', 'Status'];

            $callback = function () use ($columns, $projects) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                $count = 1;
                foreach ($projects as $project) {
                    $staffs     = $project->staffs ? json_decode($project->staffs, true) : [];
                    $staffNames = [];
                    foreach ($staffs as $staff) {
                        $user = get_user($staff);
                        if ($user) {
                            $staffNames[] = $user->name;
                        }
                    }
                    $staff_name = implode(', ', $staffNames);

                    fputcsv($file, [
                        $count,
                        $project->title,
                        $project->code,
                        $project->user?->name,
                        $staff_name,
                        currency($project->budget),
                        $project->progress . '%',
                        ucwords(str_replace('_', ' ', $project->status)),
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


    public function filter($param)
    {
        if ($param == 'project') {
            $page_data['clients']    = User::where('role_id', 2)->get();
            $page_data['staffs']     = User::where('role_id', 3)->get();
            $page_data['categories'] = Category::where('parent', '!=', 0)->get();
            return view('projects.filter', $page_data);
        }
    }
}
