<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 24/02/2018
 * Time: 23:46
 */

namespace App\Service;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Flex\Response;



class Login
{
    private $entityManager;
    private $encoder;
    private $user;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder) {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    public function form(Request $request) {

        $formFactory = Forms::createFormFactory();

        $form = $formFactory->createBuilder()
            ->add('username', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('submit', ButtonType::class)
            ->getForm();

        return $form->createView();
    }

    public function login($username, $password) {

        $user = new Users();

        $user = $this->entityManager->getRepository("App:Users")
            ->findOneBy(array('username' => $username));

        if(!$user){
            return false;
        }

        if(!$this->encoder->isPasswordValid($user, $password)) {
            return false;
        } else {
            $session = new Session();
            $session->set('username', $user->getUsername());
            if($user->getRole() == 'admin') {
                return new Response('admin');
            }
            return new Response('user');
        }
    }

    public function logout() {
        if($this->isLogged()) {
            $session = new Session();
            $session->remove('username');
            return true;
        }
        return false;
    }

    public function isLogged() {

        $session = new Session();
        if($session->get('username')) {
            return $session->get('username');
        }
        return false;
    }


}