<?php

namespace App\Http\Controllers;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Models\FileUploader;
use App\Models\payment_gateway\Ccavenue;
use App\Models\payment_gateway\Doku;
use App\Models\payment_gateway\Pagseguro;
use App\Models\payment_gateway\Paystack;
use App\Models\payment_gateway\Paytm;
use App\Models\payment_gateway\Skrill;
use App\Models\payment_gateway\Xendit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    public function index()
    {
        $payment_details = session('payment_details');
        if (!$payment_details || !is_array($payment_details) || count($payment_details) <= 0) {
            Session::flash('error', get_phrase('Payment not configured yet'));
            return redirect()->back();
        }
        if ($payment_details['payable_amount'] <= 0) {
            Session::flash('error', get_phrase("Payable amount cannot be less than 1"));
            return redirect()->to($payment_details['cancel_url']);
        }

        $page_data['payment_details']  = $payment_details;
        $page_data['payment_gateways'] = DB::table('payment_gateways')->where('status', 1)->get();
        return view('payment.index', $page_data);
    }

    public function show_payment_gateway_by_ajax($identifier)
    {
        $page_data['payment_details'] = session('payment_details');
        $page_data['payment_gateway'] = DB::table('payment_gateways')->where('identifier', $identifier)->first();
        return view('payment.' . $identifier . '.index', $page_data);
    }

    public function payment_success($identifier, Request $request)
    {

        $payment_details = session('payment_details');
        $payment_gateway = DB::table('payment_gateways')->where('identifier', $identifier)->first();
        $model_name      = $payment_gateway->model_name;
        $model_full_path = str_replace(' ', '', 'App\Models\payment_gateway\ ' . $model_name);

        $status = $model_full_path::payment_status($identifier, $request->all());
        if ($status === true) {
            $success_model    = $payment_details['success_method']['model_name'];
            $success_function = $payment_details['success_method']['function_name'];

            $model_full_path = str_replace(' ', '', 'App\Models\ ' . $success_model);
            return $model_full_path::$success_function($identifier);
        } else {
            Session::flash('success', get_phrase('Payment failed! Please try again.'));
            redirect()->to($payment_details['cancel_url']);
        }

    }

    public function payment_create($identifier)
    {
        $payment_details      = session('payment_details');
        $payment_gateway      = DB::table('payment_gateways')->where('identifier', $identifier)->first();
        $model_name           = $payment_gateway->model_name;
        $model_full_path      = str_replace(' ', '', 'App\Models\payment_gateway\ ' . $model_name);
        $created_payment_link = $model_full_path::payment_create($identifier);
        return redirect()->to($created_payment_link);
    }

    public function payment_razorpay($identifier)
    {
        $payment_details = session('payment_details');
        $payment_gateway = DB::table('payment_gateways')->where('identifier', $identifier)->first();
        $model_name      = $payment_gateway->model_name;
        $model_full_path = str_replace(' ', '', 'App\Models\payment_gateway\ ' . $model_name);
        $data            = $model_full_path::payment_create($identifier);

        return view('payment.razorpay.payment', compact('data'));
    }

    public function payment_paytm(Request $request)
    {
        $user    = DB::table('users')->where('id', $request->user)->first();
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order'         => $user->phone . "_" . rand(1, 1000),
            'user'          => auth()->user()->id,
            'mobile_number' => $user->phone,
            'email'         => $user->email,
            'amount'        => $request->amount,
            'callback_url'  => route('payment.status', ['identifier' => 'paytm']),
        ]);
        return $payment->receive();
    }

    public function paytm_paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response    = $transaction->response();
        $order_id    = $transaction->getOrderId(); // return a order id
        $transaction->getTransactionId(); // return a transaction id

        // update the db data as per result from api call
        if ($transaction->isSuccessful()) {
            Paytm::where('order_id', $order_id)->update(['status' => 1, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is successfull.");
        } else if ($transaction->isFailed()) {
            Paytm::where('order_id', $order_id)->update(['status' => 0, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is failed.");
        } else if ($transaction->isOpen()) {
            Paytm::where('order_id', $order_id)->update(['status' => 2, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is processing.");
        }
        $transaction->getResponseMessage(); //Get Response Message If Available

    }

    public function payment_notification(Request $request, $identifier)
    {
        if ($identifier == 'doku') {
            Doku::payment_status($identifier, $request->all(), $request->headers->all());
        }
    }
    public function doku_checkout($identifier)
    {
        $payment_gateway = DB::table('payment_gateways')->where('identifier', $identifier)->first();
        $keys            = json_decode($payment_gateway->keys, true);
        $test_mode       = $payment_gateway->test_mode == 1 ? 1 : 0;
        $client_id       = $keys['client_id'];
        if ($test_mode == 1) {
            $key        = $keys['public_test_key'];
            $secret_key = $keys['secret_test_key'];
        } else {
            $key        = $keys['public_live_key'];
            $secret_key = $keys['secret_live_key'];
        }

        $user_id         = auth()->user()->id;
        $user            = DB::table('users')->where('id', $user_id)->first();
        $currency        = $payment_gateway->currency;
        $payment_details = session('payment_details');
        $product_title   = $payment_details['items'][0]['title'];
        $amount          = $payment_details['items'][0]['price'];

        //Store temporary data
        Doku::storeTempData();

        $requestBody = array(
            'order'    => array(
                'amount'         => $amount,
                'invoice_number' => 'INV-' . rand(1, 10000), // Change to your business logic
                'currency' => $currency,
                'callback_url'   => $payment_details["success_url"] . "/$identifier",
                'line_items'     => array(
                    0 => array(
                        'name'     => $product_title,
                        'price'    => $amount,
                        'quantity' => 1,
                    ),
                ),
            ),
            'payment'  => array(
                'payment_due_date' => 60,
            ),
            'customer' => array(
                'id'      => 'CUST-' . rand(1, 1000), // Change to your customer ID mapping
                'name' => $user->name,
                'email'   => $user->email,
                'phone'   => $user->phone,
                'address' => $user->address,
                'country' => 'ID',
            ),
        );

        $requestId     = rand(1, 100000); // Change to UUID or anything that can generate unique value
        $dateTime      = gmdate("Y-m-d H:i:s");
        $isoDateTime   = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        $clientId      = $client_id; // Change with your Client ID
        $secretKey     = $secret_key; // Change with your Secret Key


        if ($test_mode == 1) {
            $getUrl = 'https://api-sandbox.doku.com';
        } else {
            $getUrl = 'https://api.doku.com';
        }

        $targetPath = '/checkout/v1/payment';
        $url        = $getUrl . $targetPath;

        // Generate digest
        $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

        // Prepare signature component
        $componentSignature = "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $dateTimeFinal . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digestValue;

        // Generate signature
        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));

        // Execute request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Client-Id:' . $clientId,
            'Request-Id:' . $requestId,
            'Request-Timestamp:' . $dateTimeFinal,
            'Signature:' . "HMACSHA256=" . $signature,
        ));

        // Set response json
        $responseJson = curl_exec($ch);
        $httpCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        // Echo the response
        if (is_string($responseJson) && $httpCode == 200) {
            return json_decode($responseJson, true);
        } else {
            return null;
        }
    }


}
