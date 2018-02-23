<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 22/02/2018
 * Time: 19:34
 */

namespace App\Service;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;

class Register
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function form(Request $request) {

        $formFactory = Forms::createFormFactory();

        $form = $formFactory->createBuilder()
            ->setAction('/')
            ->setMethod('POST')
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('submit', ButtonType::class)
            ->getForm();

        return $form->createView() ? $form->createView() : false;
    }

    public function addNewUser($username, $password) {
        if(self::validateUsername($username) && self::validatePassword($password)) {
            $user = new Users();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setRole('user');
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return true;
        }
    }

    static function validateUsername($username) {
        return true;
    }

    static function validatePassword($password) {
        return true;
    }

}