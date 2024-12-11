<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailSettingsController extends Controller
{
    public function smtpSettings(Request $request){
        if ($request->isMethod('POST')) {

            $rules = [
                'com_site_global_email' => 'nullable|string',
                'com_site_smtp_mail_mailer' => 'nullable|string',
                'com_site_smtp_mail_host' => 'nullable|string',
                'com_site_smtp_mail_post' => 'nullable|string',
                'com_site_smtp_mail_username' => 'nullable|string',
                'com_site_smtp_mail_password' => 'nullable|string',
                'com_site_smtp_mail_encryption' => 'nullable|string',
            ];

            $this->validate($request, $rules);

            foreach ($rules as $field) {
                $value = $request->input($field) ?? null;
                com_option_update($field, $value);
            }

            updateEnvValues([
                'MAIL_DRIVER' => $request->com_site_smtp_mail_mailer,
                'MAIL_HOST' => $request->com_site_smtp_mail_host,
                'MAIL_PORT' => $request->com_site_smtp_mail_post,
                'MAIL_USERNAME' => $request->com_site_smtp_mail_username,
                'MAIL_PASSWORD' => '"'.$request->com_site_smtp_mail_password.'"',
                'MAIL_ENCRYPTION' => $request->com_site_smtp_mail_encryption,
            ]);

            return $this->success(translate('messages.update_success', ['name' => 'SMTP Settings']));
        }else{
            $fields = [
                'com_site_global_email',
                'com_site_smtp_mail_mailer',
                'com_site_smtp_mail_host',
                'com_site_smtp_mail_post',
                'com_site_smtp_mail_username',
                'com_site_smtp_mail_password',
                'com_site_smtp_mail_encryption',
            ];

            $data = [];
            foreach ($fields as $field) {
                $data[$field] = com_option_get($field);
            }

            return $this->success($data);
        }

    }
}
