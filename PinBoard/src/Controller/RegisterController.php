<?php

namespace App\Controller;

use App\Service\Register;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class RegisterController extends Controller
{
    public function indexAction(Request $request, Register $register) {

        $form = $register->form($request);
        return $this->render('register.html.twig', array("form" => $form));
    }

    public function checkUsernameAvaibility(Request $request, Register $register) {

        $username = $request->get('username');
        $check = $register->checkUserNameAvaibility($username);
        if($check) {
            return new Response(0);
        }
        return new Response(1);
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

}
