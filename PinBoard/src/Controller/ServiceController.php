<?php

namespace App\Controller;

use App\Entity\Service;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ServiceController extends Controller
{
    /**
     * @Route("/", name="")
     */
    public function index(Request $request)
    {

    return ServiceController::form($request);

    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/form", name="form")
     */
    public function form(Request $request)
    {

        $categories = $this->getDoctrine()->getRepository(Service::class)->findAll();

        return $this->render('index.html.twig', array(
            'categories' => $categories,
        ));

    }

}
