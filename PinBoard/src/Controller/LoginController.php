<?php

namespace App\Controller;

use App\Service\Login;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
    public function indexAction(Request $request, Login $login) {
        if(!$login->isLogged()) {
            $form = $login->form($request);
            return $this->render('/service/login/login.html.twig', array("form" => $form));
        }
        return $this->redirect('/');
    }

    public function loginAction(Request $request, Login $login) {
        $username = $request->get('username');
        $password = $request->get('password');

        if ($login->isLogged()) {
            return $this->redirect('/');
        }

        if($login->login($username, $password)) {
            if($login->login($username, $password)->getBody() == 'admin') {
                return new Response(2);
            }
            if($login->login($username, $password)->getBody() == 'user') {
                return new Response(1);
            }
        }

        return new Response(0);
    }

    public function logoutAction(Login $login) {
        if($login->logout()) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function resetPasswordAction(Request $request, Login $login) {

        if($login->isLogged()) {
            return $this->redirect('/');
        }

        return $this->render('service/login/register.html.twig');
    }
}
