<?php

namespace App\Controller;

use App\Service\Admin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{

    public function indexAction(Request $request, Admin $admin) {
        if($admin->isAdmin()) {
            return $this->render('/service/panel/panel.html.twig', array("admin" => "true"));
        }
        return $this->redirect('/login');

    }
}
