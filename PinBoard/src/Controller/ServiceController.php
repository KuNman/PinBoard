<?php

namespace App\Controller;

use App\Service\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ServiceController extends Controller
{
    /**
     */
    public function maps() {
        return $this->render('maps.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request, Service $service)
    {
        $service = new Service();
        $form = $service->form($request);

        return $this->render('index.html.twig', array("form" => $form));
    }

    /**
     */
    public function resultsAction(Request $request) {

        $service = new Service();
        $results = $service->results($request);

        return $this->render('results.html.twig', array("results" => $results));
    }

}
