<?php

namespace App\Controller;

use App\Service\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ServiceController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Service $service)
    {
        $form = $service->form();

        return $this->render('/service/index.html.twig', array("form" => $form));
    }

    /**
     */
    public function resultsAction(Request $request, Service $service) {

        $results = $service->results($request);

        return $this->render('/service/results.html.twig', array("results" => $results));
    }

}
