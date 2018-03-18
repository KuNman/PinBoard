<?php

namespace App\Controller;

use App\Service\Admin;
use App\Service\Login;
use App\Service\NormalUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $normalUser;
    private $login;
    private $admin;

    public function __construct(NormalUser $normalUser, Login $login, Admin $admin) {
        $this->normalUser = $normalUser;
        $this->login = $login;
        $this->admin = $admin;
    }

    public function indexAction() {
        if($this->login->isLogged()) {
            return $this->render('/service/panel/panel.html.twig', array(
                "normalUser" => true,
                "countries" => $this->normalUser->searchCountries(),
                "userLangs" => $this->normalUser->getUserLangs($this->login->isLogged(1)),
                "userTasks" => $this->normalUser->getUserTasks($this->login->isLogged(1))
            ));
        }
        return $this->redirect('/login');
    }

    public function searchJobsAction($lang) {
        return new JsonResponse($this->normalUser->searchJobs($lang));
    }

    public function searchCountriesAction($lang) {
        return new JsonResponse($this->normalUser->searchCountries($lang));
    }

    public function searchAreaInCountryAction(Request $request) {
        $country = $request->get('country');
        return new JsonResponse($this->normalUser->searchAreaInCountry($country));
    }

    public function addTaskAction(Request $request) {
        if($this->normalUser->addTask($request, $this->login->isLogged(1))) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function editTaskAction($id) {
        if($this->login->isLogged()) {
            return $this->render('service/panel/panel.html.twig', array(
                "normalUser" => true,
                "countries" => $this->normalUser->searchCountries(),
                "task" => $this->normalUser->getTaskInfo($id),
            ));
        }
    }

    public function addUserLangsAction(Request $request) {
        if($this->normalUser->addUserLangs($request, $this->login->isLogged(1))) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function removeTaskAction($id) {
        if($this->normalUser->removeTask($id, $this->login->isLogged(1))) {
            if($this->admin->sendNotificationMailToUser($this->login->isLogged(1), 'notifyTaskRemoved')) {
                return new Response(1);
            }
        }
        return new Response(0);
    }
}
