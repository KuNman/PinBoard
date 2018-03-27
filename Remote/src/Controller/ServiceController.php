<?php

namespace App\Controller;

use App\Service\Admin;
use App\Service\Login;
use App\Service\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ServiceController extends Controller
{

    private $service;
    private $admin;
    private $login;

    public function __construct(Service $service, Admin $admin, Login $login) {
        $this->service = $service;
        $this->admin = $admin;
        $this->login = $login;
    }

    public function indexAction() {
        return $this->render('/service/index.html.twig', array("form" => $this->service->form()));
    }

    public function resultsAction(Request $request) {
        $results = $this->service->results($request);
        return $this->render('/service/results.html.twig', array("results" => $results));
    }

    public function getJobsNamesAction(Request $request) {
        return new JsonResponse($this->service->getJobsNames($request->get('lang')));
    }

    public function getCountriesAction(Request $request) {
        return new JsonResponse($this->service->getCountries($request->get('lang')));
    }

    public function getTaskIdsAction() {
        return new JsonResponse($this->service->getTaskIds());
    }

    public function getAreasAction() {
        return new JsonResponse($this->service->getAreas());
    }

    public function getCitiesAction() {
        return new JsonResponse($this->service->getCities());
    }

    public function getUserIdsOrUsernamesAction($data) {
        if($this->admin->isAdmin($this->login->isLogged())) {
            return new JsonResponse($this->service->getUserIdsOrUsernames($data));
        }
    }
}
