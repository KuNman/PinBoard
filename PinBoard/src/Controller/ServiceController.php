<?php

namespace App\Controller;

use App\Service\Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
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
        return $form ? $form : 'error';
    }

    /**
     */
    public function results(Request $request) {
         echo "<pre>";
         print_r($_POST);
         echo "</pre>";
    }

}
