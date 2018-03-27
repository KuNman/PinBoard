<?php

namespace App\Controller;

use App\Service\Login;
use App\Service\Mail;
use App\Service\Register;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;



class RegisterController extends Controller
{
    private $register;
    private $login;

    public function __construct(Register $register, Login $login) {
        $this->register = $register;
        $this->login = $login;
    }

    public function indexAction(Request $request) {

        if ($this->login->isLogged()) {
            return $this->redirect('/');
        }
        $form = $this->register->form($request);
        return $this->render('/service/login/register.html.twig', array("form" => $form));
    }

    public function checkUsernameAvaibilityAction(Request $request) {

        $username = $request->get('username');

        if($this->register->checkUserNameAvaibility($username)) {
            return new Response(0);
        }
        return new Response(1);
    }

    public function sendRegisterMailAction(Request $request, Mail $mail) {
        $username = $request->get('username');
        $body = $this->register->generateActivationLink($username);

        if($mail->sendMail('Hello', $username, $body)) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function registerUserAction(Request $request) {

        $username = $request->get('username');
        $password = $request->get('password');

        if($this->register->addNewUser($username, $password)) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function activateUserAction(Request $request, $username, $time) {
        if(!$this->register->checkUserNameAvaibility($username)) {
            if($this->register->validateLink($time)) {
                $form = $this->register->form($request, $username);
                return $this->render('/service/login/register.html.twig', array("form" => $form, "username" => $username));
            }
            return new Response('error');
        }
        return new Response('link not active');

    }
}
