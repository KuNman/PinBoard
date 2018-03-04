<?php

namespace App\Controller;

use App\Service\Login;
use App\Service\NormalUser;
use function MongoDB\BSON\toJSON;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $normalUser;
    private $login;

    public function __construct(NormalUser $normalUser, Login $login) {
        $this->normalUser = $normalUser;
        $this->login = $login;
    }


    public function indexAction() {
        if($this->login->isLogged()) {
            return $this->render('/service/panel/panel.html.twig', array("normaluser" => true));
        }
        return $this->redirect('/login');
    }

    public function searchJobsAction($lang) {
        return new JsonResponse($this->normalUser->searchJobs($lang));
    }

    public function searchCountriesAction($lang) {
        return new JsonResponse($this->normalUser->searchCountries($lang));
    }
}
