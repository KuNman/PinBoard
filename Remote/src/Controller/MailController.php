<?php

namespace App\Controller;

use App\Service\Mail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{

    public function sendMailAction(Mail $mail, Request $request) {
        if($mail->sendMail($subject, $to, $body)) {
            return new Response(1);
        }
        return new Response(0);

    }

}
