<?php

namespace App\Controller;

use App\Entity\Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    /**
     * @Route("/service", name="service")
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository(Service::class)->findAll();

        return $this->render('index.html.twig', array(
            'categories' => $categories,
        ));

    }
}
