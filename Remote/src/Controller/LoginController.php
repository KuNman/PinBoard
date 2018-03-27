<?php

namespace App\Controller;

use App\Service\Login;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{

    private $login;

    public function __construct(Login $login) {
        $this->login = $login;
    }

    public function indexAction(Request $request) {
        if(!$this->login->isLogged()) {
            $form = $this->login->form($request);
            return $this->render('/service/login/login.html.twig', array("form" => $form));
        }
        return $this->redirect('/');
    }

    public function loginAction(Request $request) {
        $username = $request->get('username');
        $password = $request->get('password');

        if ($this->login->isLogged()) {
            return $this->redirect('/');
        }

        return new Response($this->login->login($username, $password));
    }

    public function logoutAction() {
        if($this->login->logout()) {
            return new Response(1);
        }
        return new Response(0);
    }

    public function resetPasswordAction(Request $request) {

        if($this->login->isLogged()) {
            return $this->redirect('/');
        }

        return $this->render('service/login/register.html.twig');
    }
}
