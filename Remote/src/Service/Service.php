<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 21/02/2018
 * Time: 10:35
 */

namespace App\Service;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;

class Service
{
    public function form() {

        $formFactory = Forms::createFormFactory();

        $form = $formFactory->createBuilder()
            ->setAction('/results')
            ->setMethod('POST')
            ->add('name', TextType::class)
            ->add('place', TextType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        return $form->createView() ? $form->createView() : false;
    }


    public function results(Request $request) {

        $response = $request->request->get('form');
        $name = $response["name"];
        $place = $response["place"];
        return $name;
    }
}