<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 25/02/2018
 * Time: 17:22
 */

namespace App\Service;


class Mail
{

    private $mailer;

    public function __construct(\Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function sendMail($subject, $to, $body) {
        $message = (new \Swift_Message($subject))
            ->setFrom('admin@admin.com')
            ->setTo($to)
            ->setBody($body);

        if($this->mailer->send($message)) {
            return true;
        }
        return false;
    }

}