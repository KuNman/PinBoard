<?php

namespace App\Controller;

use App\Service\Login;
use App\Service\NormalUser;
use function MongoDB\BSON\toJSON;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
            return $this->render('/service/panel/panel.html.twig', array(
                "normaluser" => true,
                "countries" => $this->normalUser->searchCountries()
            ));
        }
        return $this->redirect('/login');
    }

    public function searchJobsAction($lang) {
        return new JsonResponse($this->normalUser->searchJobs($lang));
    }

    public function searchCountriesAction($lang) {
        return new JsonResponse($this->normalUser->searchCountries($lang));
    }

    public function searchAreaInCountryAction(Request $request) {
        $country = $request->get('country');
        return new JsonResponse($this->normalUser->searchAreaInCountry($country));
    }

    public function addTaskAction(Request $request) {
        if($this->normalUser->addTask($request, $this->login->isLogged(1))) {
            return new Response(1);
        }
        return new Response(0);
    }
}
