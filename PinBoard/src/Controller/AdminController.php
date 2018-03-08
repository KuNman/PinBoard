<?php

namespace App\Controller;

use App\Service\Admin;
use App\Service\Login;
use App\Service\NormalUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{

    private $admin;
    private $login;
    private $normalUser;

    public function __construct(Admin $admin, Login $login, NormalUser $normalUser) {
        $this->admin = $admin;
        $this->login = $login;
        $this->normalUser = $normalUser;
    }

    public function indexAction(Request $request) {
        if($this->login->isLogged()) {
            if($this->admin->isAdmin($this->login->isLogged())) {
                return $this->render('/service/panel/panel.html.twig', array(
                    "admin" => "true",
                    "countries" => $this->normalUser->searchCountries(),
                    "missingJobNameEn" => $this->admin->checkMissingJobNameEn(),
                    "missingJobNameFr" => $this->admin->checkMissingJobNameFr(),
                    "notActiveTasks" => $this->admin->checkNotActiveTasks()
                ));
            }
        }

        return $this->redirect('/login');

    }

    public function addNewJobNameAction(Request $request) {
        if($this->admin->isAdmin($this->login->isLogged())) {
            if($this->admin->addNewJobName($request)) {
                return new Response(1);
            }
        }
        return new Response(0);
    }

    public function addNewCountryNameAction(Request $request) {
        if($this->admin->isAdmin($this->login->isLogged())) {
            if($this->admin->addNewCountryName($request)) {
                return new Response(1);
            }
        }
        return new Response(0);
    }

    public function addNewAreaNameAction(Request $request) {
        if($this->admin->isAdmin($this->login->isLogged())) {
            if($this->admin->addNewAreaName($request)) {
                return new Response(1);
                }
            }
            return new Response(0);
        }

    public function addTaskAction(Request $request) {
        if($this->admin->addTask($request)) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function addJobEnNameAction(Request $request) {
        if($this->admin->isAdmin($this->login->isLogged())) {
            if($this->admin->addJobEnName($request)) {
                return new Response(1);
            }
        }
        return new Response(0);
    }

    public function addJobFrNameAction(Request $request) {
        if($this->admin->isAdmin($this->login->isLogged())) {
            if($this->admin->addJobFrName($request)) {
                return new Response(1);
            }
        }
        return new Response(0);
    }

}
