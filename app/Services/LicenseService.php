<?php

namespace App\Services;



use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LicenseService
{
    public function activate(string $licenseKey, string $envatoUsername): array
    {

        $siteUrl = url('/');
        $user_agent = request()->header('User-Agent');
        $php_version = phpversion();
        $mysql_version = $this->getMysqlVersionDetails();
        $extension = get_loaded_extensions();
        $ip = request()->ip();
        $site_version = com_option_get('application_core_version');

        // Unique signature hash (prevents fake requests)
        $signature = hash_hmac('sha256', $licenseKey . $envatoUsername . $siteUrl, 'bravosoft');

        $response = Http::post(
            $this->getMainApiUrl()."/license/activate/{$licenseKey}".$envatoUsername, [
            'signature'     => $signature,
            'agent'     => $user_agent,
            'site' => $siteUrl,
            'ip' => $ip,
            'php_version'   => $php_version,
            'mysql_info' => json_encode($mysql_version),
            'php_extensions' => implode(",",$extension),
            'site_version' => $site_version,
          ]
        );

        $result = $response->object();
        $message = "Activation failed. Please retry or contact support.";




    }

    private function getMysqlVersionDetails(){
        $mysql_version = DB::scalar("select version()");
        $mariadb_version = '';

        if (strpos($mysql_version, 'Maria') !== false) {
            $mariadb_version = 'MariaDB';
            $mysql_version = '';
        }

        return [
          'type' => strpos($mysql_version, 'Maria') !== false ? 'MariaDB' : 'mysql',
          'version' => strpos($mysql_version, 'Maria') !== false ? $mariadb_version : $mysql_version,
        ];

    }

    private function getMainApiUrl()
    {
        return 'https://barvosoft-license-server.com/api/';
    }

}