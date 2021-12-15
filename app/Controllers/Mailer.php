<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Mailer extends Controller
{
    public function index()
    {
        try {
            $mailer = new \App\Models\Mailer();
            $settingsModel = new \App\Models\Settings();

            $setting_from = $settingsModel->where('name', 'email_from')->first();
            $setting_host = $settingsModel->where('name', 'SMTPHost')->first();
            $setting_pass = $settingsModel->where('name', 'SMTPPass')->first();

            $date = date("Y-m-d H:i:s");
            $mailer->where('send_date<', $date);
            $mailer->where('status', 0);
            $res = $mailer->first();

            $email = \Config\Services::email();

            $config['protocol'] = 'smtp';
            $config['SMTPHost'] = $setting_host->value;
            $config['SMTPUser'] = $setting_from->value;
            $config['SMTPPass'] = $setting_pass->value;
            $config['SMTPPort'] = '465';
            $config['SMTPCrypto'] = 'ssl';
            $config['mailType'] = 'html';

            $email->initialize($config);

            $email->setFrom($setting_from->value, 'MNTK2021');
            $email->setTo($res->user_email);
            $email->setSubject($res->subject);
            $email->setMessage($res->text);
            $result = $email->send();

            if ($result) {
                $res->status = 1;
                $mailer->save($res);
            }else{
                echo 'error';
                $email->printDebugger(['headers']);
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}