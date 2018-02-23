<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\Register;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class RegisterController extends Controller
{
    public function indexAction(Request $request, Register $register) {

        $form = $register->form($request);

        return $this->render('register.html.twig', array("form" => $form));
    }

    public function registerUserAction(Request $request, Register $register) {

        $username = $request->get('username');
        $password = $request->get('password');

        $newUser = $register->addNewUser($username, $password);
        return $newUser ? $this->redirect('/') : false;
        }

}
