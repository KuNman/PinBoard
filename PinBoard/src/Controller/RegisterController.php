<?php

namespace App\Controller;

use App\Service\Register;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function indexAction(Request $request, Register $register) {

        $newUser = new Register();
        $form = $newUser->form($request);
        return $this->render('register.html.twig', array("form" => $form));
    }
}
