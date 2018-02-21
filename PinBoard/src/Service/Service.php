<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 21/02/2018
 * Time: 10:35
 */

namespace App\Service;


class Service
{
    public function form() {

        $form = $this->createFormBuilder()
            ->add('task', TextType::class)
            ->add('location', TextType::class)
            ->getForm();

        return $form->createView();
    }
}