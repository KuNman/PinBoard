<?php

namespace App\Controller;

use App\Entity\Service;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @Route("/maps", name="maps")
     */
    public function maps() {
        return $this->render('maps.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/form", name="form")
     */
    public function form(Request $request)
    {

        $builder = new Service();

        $builder = $this->createFormBuilder($builder)
            ->setAction($this->generateUrl('results'))
            ->setMethod('POST')
            ->add('name', EntityType::class, array(
                'class' => Service::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
            ))
            ->add('search', SubmitType::class)
            ->getForm();

        if ($builder->isSubmitted()) {

            return $this->redirectToRoute('results');
        }

        return $this->render('index.html.twig', array(
        'form' => $builder->createView(),
    ));

    }

    /**
     * @Route("/results", name="results")
     */
    public function results(Request $request) {
        return var_dump($_POST);
    }

}
