<?php

namespace App\Controller;

use App\Service\Admin;
use App\Service\Login;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{

    public function indexAction(Request $request, Admin $admin, Login $login) {
        if($login->isLogged()) {
            $username = $login->isLogged();
            if($admin->isAdmin($username)) {
                return $this->render('/service/panel/panel.html.twig', array("admin" => "true"));
            }
        }

        return $this->redirect('/login');

    }
}
