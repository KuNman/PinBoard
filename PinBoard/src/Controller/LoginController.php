<?php

namespace App\Controller;

use App\Service\Login;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function indexAction(Request $request, Login $login) {
        $form = $login->form($request);
        return $this->render('login.html.twig', array("form" => $form));
    }

    public function loginAction(Request $request, Login $login) {
        $username = $request->get('username');
        $password = $request->get('password');

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
}
