<?php

namespace App\Controller;

use App\Entity\Service;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ServiceController extends Controller
{
    /**
     * @Route("/", name="")
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository(Service::class)->findAll();

//        return $this->render('index.html.twig', array(
//            'categories' => $categories,
//        ));

//        return $this->redirectToRoute('form');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/form", name="form")
     */
    public static function form(Request $request)
    {

//        $task = new Task();
        $form = $this->createFormBuilder()
            ->add('name', EntityType::class, array(
                'class' => Service::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name',
            ));

        return $this->render('index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
