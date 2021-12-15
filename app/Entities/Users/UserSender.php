<?php namespace App\Entities\Users;

use CodeIgniter\Entity;

class UserSender extends Entity
{
    public static function sendPasswordMail(User $user)
    {
        $mailerModel = new \App\Models\Mailer();
        $mailer = new \App\Entities\Mailers\Mailer();
        if(empty($user->email))
            return false;

        $message = view('emails/password_recovery', [
            'name' => @$user->surname . ' ' . @$user->name,
            'site_name' => $_SERVER['HTTP_HOST'],
            'password' => @$user->origin_password
        ]);

        $mailer->user_email = $user->email;
        $mailer->text = $message;
        $mailer->send_date = date("Y-m-d H:i:s");
        $mailer->status = 0;
        $mailer->subject = 'Активация нового пароля';
        $mailerModel->save($mailer);
        return true;
    }
}