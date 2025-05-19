<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mail as sendMail;
use App\Models\NotificationSetting;

class Smtp extends Model
{
    public static function send_mail($model = "", $email = "", $token = "") {
        config([
            'mail.mailers.smtp.transport'  => get_settings('protocol'),
            'mail.mailers.smtp.host'       => get_settings('smtp_host'),
            'mail.mailers.smtp.port'       => get_settings('smtp_port'),
            'mail.mailers.smtp.encryption' => get_settings('smtp_crypto'),
            'mail.mailers.smtp.username'   => get_settings('smtp_user'),
            'mail.mailers.smtp.password'   => get_settings('smtp_pass'),
            'mail.from.address'            => get_settings('smtp_user'),
            'mail.from.name'               => get_settings('system_name'),
        ]);

        $template = NotificationSetting::where('type', $model)->first();
        $user_details = User::where('email', $email)->first();
        $admin_details = User::where('email', $email)->first();

        if ($model == 'forget-password') {
            $decoded = json_decode($template->subject);
            foreach ($decoded as $key => $value) {
           
                $message = json_decode($template->template)->$key;
                $message = str_replace('[forget_password_link]', route('password.reset', ['token' => $token,'email' =>urlencode($email)]), $message);
                $message = str_replace('[client_name]', $user_details->name, $message);
                $message = str_replace('[site_email]', get_settings('system_email'), $message);
                $message = str_replace('[address]', get_settings('address'), $message);
                $message = str_replace('[footer_text]', get_settings('footer_text'), $message);

                $details = [
                    'subject' => $value,
                    'view' => 'emails.forgot',
                    'message' => $message,
                ];
                Mail::to($email)->send(new sendMail($details));
            }
            $status = 'We send forget password email to your mail';
            return $status;

        }

        if($model == 'payment-conformation') {
            $decoded = json_decode($template->subject);
            foreach ($decoded as $key => $value) {
           
                $message = json_decode($template->template)->$key;
                $message = str_replace('[client_name]', $user_details->name, $message);
                $message = str_replace('[site_email]', get_settings('system_email'), $message);
                $message = str_replace('[address]', get_settings('address'), $message);
                $message = str_replace('[footer_text]', get_settings('footer_text'), $message);

                $details = [
                    'subject' => $value,
                    'view' => 'emails.template',
                    'message' => $message,
                ];
                Mail::to($email)->send(new sendMail($details));
            }
        } 

        
    }
}
