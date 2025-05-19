<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;
    public $timestamps = false;

    public $table = 'project_invoices';

    protected $fillable = [
        'title',
        'project_id',
        'user_id',
        'payment',
        'payment_method',
        'status',
        'timestamps',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public static function payment_invoice($identifier)
    {
        // Retrieve payment details from the session
        $payment_details = session('payment_details');

        if (Session::has('keys')) {
            $transaction_keys          = session('keys');
            $transaction_keys          = json_encode($transaction_keys);
            $payment['transaction_id'] = $transaction_keys;
            $remove_session_item[]     = 'keys';
        }
        if (Session::has('session_id')) {
            $transaction_keys      = session('session_id');
            $payment['session_id'] = $transaction_keys;
            $remove_session_item[] = 'session_id';
        }

        for ($i = 0; $i < count($payment_details['items']); $i++) {
            $price = $payment_details['items'][$i]['price'];

            Project_invoice::where('id', $payment_details['items'][$i]['id'])
                ->update([
                    'payment_method' => $identifier,
                    'status'        => 'paid',
                ]);

            $payment['invoice_id']      = $payment_details['items'][$i]['id'];
            $payment['amount']          = $price;
            $payment['date_added']      = time();
            $payment['project_code']    = $payment_details['items'][$i]['project_code'];
            $payment['user_id']         = Auth::id();
            $payment['payment_type']    = $identifier;
            $payment['payment_purpose'] = $payment_details['payment_purpose'];
            DB::table('payment_histories')->insert($payment);
        }

        Smtp::send_mail('payment-conformation', $payment_details['items'][0]['user_email']);

        // Clear session items
        $remove_session_item[] = 'payment_details';
        Session::forget($remove_session_item);
        Session::flash('success', 'Invoice payment completed successfully.');
        return redirect()->route(get_current_user_role() . '.project.details', [$payment_details['items'][0]['project_code'], 'invoice']);
    }
}
