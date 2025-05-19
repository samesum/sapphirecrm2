<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\Language;
use App\Models\Language_phrase;
use App\Models\NotificationSetting;
use App\Models\Payment_gateway;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function system_settings()
    {
        return view('settings.system_setting');
    }

    public function system_settings_update(Request $request)
    {
        $data = $request->all();

        array_shift($data);

        foreach ($data as $key => $item) {
            Setting::where('type', $key)->update(['description' => $item]);
        }

        return redirect()->back()->with('success', get_phrase('System settings has been updated.'));
    }

    public function payment_settings()
    {
        return view('settings.payment_setting');
    }

    public function payment_settings_update(Request $request)
    {
        $data = $request->all();
        array_shift($data);

        if ($request->top_part == 'top_part') {
            foreach ($data as $key => $item) {
                Setting::where('type', $key)->update(['description' => $item]);
            }
        } else {
            if ($request->identifier == 'paypal') {
                $paypal = [
                    'sandbox_client_id'     => $data['sandbox_client_id'],
                    'sandbox_secret_key'    => $data['sandbox_secret_key'],
                    'production_client_id'  => $data['production_client_id'],
                    'production_secret_key' => $data['production_secret_key'],
                ];
                $paypal       = json_encode($paypal);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $paypal;
            } elseif ($request->identifier == 'stripe') {
                $stripe = [
                    'public_key'      => $data['public_key'],
                    'secret_key'      => $data['secret_key'],
                    'public_live_key' => $data['public_live_key'],
                    'secret_live_key' => $data['secret_live_key'],
                ];
                $stripe       = json_encode($stripe);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $stripe;
            } elseif ($request->identifier == 'razorpay') {
                $razorpay = [
                    'public_key' => $data['public_key'],
                    'secret_key' => $data['secret_key'],

                ];
                $razorpay     = json_encode($razorpay);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $razorpay;
            } elseif ($request->identifier == 'flutterwave') {
                $flutterwave = [
                    'public_key' => $data['public_key'],
                    'secret_key' => $data['secret_key'],

                ];
                $flutterwave  = json_encode($flutterwave);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $flutterwave;
            } elseif ($request->identifier == 'paytm') {
                $paytm = [
                    'public_key' => $data['public_key'],
                    'secret_key' => $data['secret_key'],

                ];
                $paytm        = json_encode($paytm);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $paytm;
            } elseif ($request->identifier == 'offline') {
                $offline = [
                    'bank_information' => $data['bank_information'],

                ];
                $offline = json_encode($offline);
                $data    = array_splice($data, 0, 4);

                $data['keys'] = $offline;
                unset($data['bank_information']);
            } elseif ($request->identifier == 'paystack') {
                $paystack = [
                    'secret_test_key' => $data['secret_test_key'],
                    'public_test_key' => $data['public_test_key'],
                    'secret_live_key' => $data['secret_live_key'],
                    'public_live_key' => $data['public_live_key'],
                ];
                $paystack     = json_encode($paystack);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $paystack;
            } elseif ($request->identifier == 'ccavenue') {
                $ccavenue = [
                    'ccavenue_merchant_id' => $data['ccavenue_merchant_id'],
                    'ccavenue_working_key' => $data['ccavenue_working_key'],
                    'ccavenue_access_code' => $data['ccavenue_access_code'],
                ];
                $ccavenue     = json_encode($ccavenue);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $ccavenue;
            } elseif ($request->identifier == 'pagseguro') {
                $pagseguro = [
                    'api_key'         => $data['api_key'],
                    'secret_key'      => $data['secret_key'],
                    'other_parameter' => $data['other_parameter'],
                ];
                $pagseguro    = json_encode($pagseguro);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $pagseguro;
            } elseif ($request->identifier == 'iyzico') {
                $iyzico = [
                    'api_test_key'    => $data['api_test_key'],
                    'secret_test_key' => $data['secret_test_key'],
                    'api_live_key'    => $data['api_live_key'],
                    'secret_live_key' => $data['secret_live_key'],
                ];
                $iyzico       = json_encode($iyzico);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $iyzico;
            } elseif ($request->identifier == 'xendit') {
                $xendit = [
                    'api_key'         => $data['api_key'],
                    'secret_key'      => $data['secret_key'],
                    'other_parameter' => $data['other_parameter'],
                ];
                $xendit       = json_encode($xendit);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $xendit;
            } elseif ($request->identifier == 'payu') {
                $payu = [
                    'pos_id'        => $data['pos_id'],
                    'second_key'    => $data['second_key'],
                    'client_id'     => $data['client_id'],
                    'client_secret' => $data['client_secret'],
                ];
                $payu         = json_encode($payu);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $payu;
            } elseif ($request->identifier == 'skrill') {
                $skrill = [
                    'skrill_merchant_email' => $data['skrill_merchant_email'],
                    'secret_passphrase'     => $data['secret_passphrase'],
                ];
                $skrill       = json_encode($skrill);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $skrill;
            } elseif ($request->identifier == 'doku') {
                $doku = [
                    'client_id'  => $data['client_id'],
                    'shared_key' => $data['shared_key'],
                ];
                $doku         = json_encode($doku);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $doku;
            } elseif ($request->identifier == 'maxicash') {
                $maxicash = [
                    'merchant_id'       => $data['merchant_id'],
                    'merchant_password' => $data['merchant_password'],
                ];
                $maxicash     = json_encode($maxicash);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $maxicash;
            } elseif ($request->identifier == 'cashfree') {
                $cashfree = [
                    'client_id'     => $data['client_id'],
                    'client_secret' => $data['client_secret'],
                ];
                $cashfree     = json_encode($cashfree);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $cashfree;
            } elseif ($request->identifier == 'aamarpay') {
                $aamarpay = [
                    'store_id'      => $data['store_id'],
                    'signature_key' => $data['signature_key'],
                ];
                $aamarpay     = json_encode($aamarpay);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $aamarpay;
            } elseif ($request->identifier == 'tazapay') {
                $tazapay = [
                    'public_key' => $data['public_key'],
                    'api_key'    => $data['api_key'],
                    'api_secret' => $data['api_secret'],
                ];
                $tazapay      = json_encode($tazapay);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $tazapay;
            }
            Payment_gateway::where('identifier', $request->identifier)->update($data);
        }

        return redirect()->back()->with('success', get_phrase('Payment settings update.'));
    }

    public function notification_settings()
    {
        return view('settings.notification_setting');
    }

    public function notification_settings_store(Request $request, $param1 = '', $id = '')
    {
        $data = $request->all();

        if ($param1 == 'smtp_settings') {
            array_shift($data);

            foreach ($data as $key => $item) {
                Setting::where('type', $key)->update(['description' => $item]);
            }

            if (isset($_GET['tab'])) {
                $page_data['tab'] = $_GET['tab'];
            } else {
                $page_data['tab'] = 'smtp-settings';
            }
            return redirect()->back()->with('success', get_phrase('SMTP setting updated.'));

        }
        if ($param1 == 'edit_email_template') {
            array_shift($data);
            unset($data['files']);
            $data['subject']  = json_encode($request->subject);
            $data['template'] = json_encode($request->template);
            NotificationSetting::where('id', $id)->update($data);

            if (isset($_GET['tab'])) {
                $page_data['tab'] = $_GET['tab'];
            } else {
                $page_data['tab'] = 'edit_email_template';
            }

            return redirect()->back()->with('success', get_phrase('Email template updated.'));

        }

        if ($param1 == 'notification_enable_disable') {

            $id                       = $request->id;
            $user_type                = $request->user_types;
            $notification_type        = $request->notification_type;
            $input_val                = $request->input_val;
            $notification_setting_row = NotificationSetting::where('id', $id)->first();
            if ($notification_type == 'system') {
                $json_to_arr                 = json_decode($notification_setting_row->system_notification, true);
                $json_to_arr[$user_type]     = $input_val;
                $data['system_notification'] = json_encode($json_to_arr);
            }
            if ($notification_type == 'email') {
                $json_to_arr                = json_decode($notification_setting_row->email_notification, true);
                $json_to_arr[$user_type]    = $input_val;
                $data['email_notification'] = json_encode($json_to_arr);
            }
            if ($notification_setting_row->is_editable == 1) {
                unset($data['notification_type']);
                unset($data['input_val']);
                unset($data['user_types']);
                NotificationSetting::where('id', $id)->update($data);

                if ($input_val == 1) {
                    $msg = 'Successfully enabled';
                } else {
                    $msg = 'Successfully disabled';
                }
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'msg'    => $msg,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function language_import(Request $request)
    {
        // Get the file name without extension
        $fileName = pathinfo($request->file('language_file')->getClientOriginalName(), PATHINFO_FILENAME);

        // Read JSON content from the uploaded file
        $jsonContent = json_decode(file_get_contents($request->file('language_file')->getPathname()), true);

        $language_name = ucfirst($fileName);

        if (Language::where('name', 'like', $language_name)->count() > 0) {
            $language_id = Language::where('name', 'like', $language_name)->first()->id;
        } else {
            $language_data['name']       = $language_name;
            $language_data['direction']  = 'ltr';
            $language_data['created_at'] = date('Y-m-d H:i:s');
            $language_id                 = Language::insertGetId($language_data);
        }

        // Insert phrases into the database
        foreach ($jsonContent as $phrase => $translated) {

            if (Language_phrase::where('language_id', $language_id)->where('phrase', $phrase)->count() > 0) {
                Language_phrase::where('language_id', $language_id)->where('phrase', $phrase)->update([
                    'translated' => $translated, // Assuming you want to store the language name
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                Language_phrase::create([
                    'language_id' => $language_id,
                    'phrase'      => $phrase,
                    'translated'  => $translated, // Assuming you want to store the language name
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()->back()->with('success', get_phrase('Language has been imported.'));

    }

    public function manage_language()
    {
        return view('settings.language_setting');
    }

    public function language_direction_update(Request $request)
    {
        Language::where('id', $request->language_id)->update(['direction' => $request->direction]);
        return true;
    }

    public function edit_phrase($lan_id)
    {
        $page_data['phrases']  = Language_phrase::where('language_id', $lan_id)->get();
        $page_data['language'] = Language::where('id', $lan_id)->first();
        return view('settings.edit_phrase', $page_data);
    }

    public function update_phrase(Request $request, $phrase_id)
    {
        Language_phrase::where('id', $phrase_id)->update(['translated' => $request->translated_phrase, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    public function phrase_import($lan_id)
    {
        $english_lan_id = Language::where('name', 'like', 'English')->first()->id;
        foreach (Language_phrase::where('language_id', $english_lan_id)->get() as $en_lan_phrase) {
            if (Language_phrase::where('language_id', $lan_id)->where('phrase', $en_lan_phrase->phrase)->count() == 0) {
                Language_phrase::insert(['language_id' => $lan_id, 'phrase' => $en_lan_phrase->phrase, 'translated' => $en_lan_phrase->translated, 'created_at' => date('Y-m-d H:i:s')]);
            }
        }
        return redirect(route('language.phrase.edit', ['lan_id' => $lan_id]));
    }

    public function language_store(Request $request)
    {

        if (Language::where('name', 'like', $request->language)->count() == 0) {
            $new_lan_id = Language::insertGetId(['name' => $request->language, 'direction' => 'ltr']);

            $english_lan_id = Language::where('name', 'like', 'English')->first()->id;

            foreach (Language_phrase::where('language_id', $english_lan_id)->get() as $en_lan_phrase) {
                Language_phrase::insert(['language_id' => $new_lan_id, 'phrase' => $en_lan_phrase->phrase, 'translated' => $en_lan_phrase->translated, 'created_at' => date('Y-m-d H:i:s')]);
            }

            return redirect()->back()->with('success', get_phrase('Language added.'));

        } else {
            return redirect()->back()->with('success', get_phrase('Language already exists.'));

        }
    }

    public function language_delete($id)
    {
        Language::where('id', $id)->delete();
        Language_phrase::where('language_id', $id)->delete();

        return redirect()->back()->with('success', get_phrase('Language deleted.'));

    }

    public function about()
    {

        $purchase_code    = get_settings('purchase_code');
        $returnable_array = array(
            'purchase_code_status' => get_phrase('Not found'),
            'support_expiry_date'  => get_phrase('Not found'),
            'customer_name'        => get_phrase('Not found'),
        );

        $personal_token = "gC0J1ZpY53kRpynNe4g2rWT5s4MW56Zg";
        $url            = "https://api.envato.com/v3/market/author/sale?code=" . $purchase_code;
        $curl           = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $purchase_code . '.json';
        $ch_verify  = curl_init($verify_url . '?code=' . $purchase_code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($cinit_verify_data, true);

        if (is_array($response) && isset($response['verify-purchase']) && count($response['verify-purchase']) > 0) {

            $item_name     = $response['verify-purchase']['item_name'];
            $purchase_time = $response['verify-purchase']['created_at'];
            $customer      = $response['verify-purchase']['buyer'];
            $licence_type  = $response['verify-purchase']['licence'];
            $support_until = $response['verify-purchase']['supported_until'];
            $customer      = $response['verify-purchase']['buyer'];

            $purchase_date = date("d M, Y", strtotime($purchase_time));

            $todays_timestamp         = strtotime(date("d M, Y"));
            $support_expiry_timestamp = strtotime($support_until);

            $support_expiry_date = date("d M, Y", $support_expiry_timestamp);

            if ($todays_timestamp > $support_expiry_timestamp) {
                $support_status = 'expired';
            } else {
                $support_status = 'valid';
            }

            $returnable_array = array(
                'purchase_code_status' => $support_status,
                'support_expiry_date'  => $support_expiry_date,
                'customer_name'        => $customer,
                'product_license'      => 'valid',
                'license_type'         => $licence_type,
            );
        } else {
            $returnable_array = array(
                'purchase_code_status' => 'invalid',
                'support_expiry_date'  => 'invalid',
                'customer_name'        => 'invalid',
                'product_license'      => 'invalid',
                'license_type'         => 'invalid',
            );
        }

        $data['application_details'] = $returnable_array;
        return view('settings.about', $data);
    }
    public function curl_request($code = '')
    {
        $purchase_code = $code;

        $personal_token = "FkA9UyDiQT0YiKwYLK3ghyFNRVV9SeUn";
        $url            = "https://api.envato.com/v3/market/author/sale?code=" . $purchase_code;
        $curl           = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $purchase_code . '.json';
        $ch_verify  = curl_init($verify_url . '?code=' . $purchase_code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($cinit_verify_data, true);

        if (is_array($response) && count($response['verify-purchase']) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function save_valid_purchase_code($action_type, Request $request)
    {
        if ($action_type == 'update') {
            $data['description'] = $request->purchase_code;

            $status = $this->curl_request($data['description']);
            if ($status) {
                Setting::where('type', 'purchase_code')->update($data);
                session()->flash('success', get_phrase('Purchase code has been updated'));
                echo 1;
            } else {
                echo 0;
            }
        } else {
            return view('settings.save_purchase_code');
        }
    }

    public function email_temp() {
        return view('settings.email_template');
    }

    public function email_temp_edit($id) {
        $page_data['template'] = NotificationSetting::where('id', $id)->first();
        return view('settings.email_temp', $page_data);
    }

    public function email_temp_update(Request $request, $id) {
        $data = [
            'template' => json_encode($request->template),
            'subject' => json_encode($request->subject),
            'setting_title' => $request->setting_title,
            'setting_sub_title' => $request->setting_sub_title
        ];
        NotificationSetting::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Template updated.');
    }

    public function system_logo_update(Request $request){
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
        
            // Check and delete old logo if it exists
            if (get_settings('logo')) {
                $oldFilePath = public_path(get_settings('logo'));
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        
            // Upload new logo
            $logo = FileUploader::upload($file, 'setting');
        
            // Check if a 'logo' record exists, update or insert accordingly
            $logoSetting = Setting::where('type', 'logo')->first();
            if ($logoSetting) {
                $logoSetting->update(['description' => $logo]);
            } else {
                Setting::create([
                    'type' => 'logo',
                    'description' => $logo,
                ]);
            }
        }
        
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
        
            // Check and delete old favicon if it exists
            if (get_settings('favicon')) {
                $oldFilePath = public_path(get_settings('favicon'));
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        
            // Upload new favicon
            $favicon = FileUploader::upload($file, 'setting');
        
            // Check if a 'favicon' record exists, update or insert accordingly
            $faviconSetting = Setting::where('type', 'favicon')->first();
            if ($faviconSetting) {
                $faviconSetting->update(['description' => $favicon]);
            } else {
                Setting::create([
                    'type' => 'favicon',
                    'description' => $favicon,
                ]);
            }
        }
        

        return redirect()->back()->with('success', 'Logo Uploaded!');
    }

    public function zoom_settings() {
        return view('settings.zoom_setting');
    }



}
