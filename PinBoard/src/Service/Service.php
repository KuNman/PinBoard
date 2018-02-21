<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 21/02/2018
 * Time: 10:35
 */

namespace App\Service;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;

class Service
{
    public function form() {
        
        $formfactory = Forms::createFormFactory();

        $form = $formfactory->createBuilder()
            ->add('name', TextType::class)
            ->add('place', TextType::class)
            ->getForm();

        return $form->createView() ? $form->createView() : false;
    }
}