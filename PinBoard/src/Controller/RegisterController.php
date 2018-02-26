<?php

namespace App\Controller;

use App\Service\Mail;
use App\Service\Register;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class RegisterController extends Controller
{
    public function indexAction(Request $request, Register $register) {

        $form = $register->form($request);
        return $this->render('/service/login/register.html.twig', array("form" => $form));
    }

    public function checkUsernameAvaibility(Request $request, Register $register) {

        $username = $request->get('username');

        $check = $register->checkUserNameAvaibility($username);

        if($check) {
            return new Response(0);
        }
        return new Response(1);
    }

    public function sendRegisterMailAction(Request $request, Mail $mail, Register $register) {
        $username = $request->get('username');
        $body = $register->generateActivationLink($username);

        if($mail->sendMail('Hello', $username, $body)) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function registerUserAction(Request $request, Register $register) {

        $username = $request->get('username');
        $password = $request->get('password');

        $newUser = $register->addNewUser($username, $password);

        if($newUser) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function activateUserAction(Request $request, $username, $time, Register $register) {
        if(!$register->checkUserNameAvaibility($username)) {
            if($register->validateLink($time)) {
                $form = $register->form($request, $username);
                return $this->render('/service/login/register.html.twig', array("form" => $form, "username" => $username));
            }
            return new Response('error');
        }
        return new Response('link not active');

    }
}
