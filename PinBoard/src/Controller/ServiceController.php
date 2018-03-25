<?php

namespace App\Controller;

use App\Service\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ServiceController extends Controller
{

    private $service;

    public function __construct(Service $service) {
        $this->service = $service;
    }

    public function indexAction() {
        return $this->render('/service/index.html.twig', array("form" => $this->service->form()));
    }

    public function resultsAction(Request $request) {
        $results = $this->service->results($request);
        return $this->render('/service/results.html.twig', array("results" => $results));
    }

}
