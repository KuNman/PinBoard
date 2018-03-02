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

    private $admin;
    private $login;

    public function __construct(Admin $admin, Login $login) {
        $this->admin = $admin;
        $this->login = $login;
    }

    public function indexAction(Request $request) {
        if($this->login->isLogged()) {
            if($this->admin->isAdmin($this->login->isLogged())) {
                return $this->render('/service/panel/panel.html.twig', array("admin" => "true"));
            }
        }

        return $this->redirect('/login');

    }

    public function addTaskAction(Request $request) {
        if($this->admin->addTask($request)) {
            return new Response(1);
        }
        return new Response(0);
    }



}
