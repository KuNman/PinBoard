<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 21/02/2018
 * Time: 10:35
 */

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Service
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
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

    public function defineLang(Request $request) {
        $lang = $request->getLocale();
                        $response = new Response();
        $response->headers->setCookie(new Cookie('aaa', 'bbb'));


//        switch($lang) {
//            case $lang == 'en':
//            case $lang == 'pl':
//            case $lang == 'fr':
//                $cookie = new Cookie('lang', $lang, strtotime('now + 10 minutes'));
//                $response = new Response();
//                $response->headers->setCookie($cookie);
//                break;
//            default:
//                $cookie = new Cookie('lang', 'ee', strtotime('now + 10 minutes'));
//                $response = new Response();
//                $response->headers->setCookie(new Cookie('aaa', 'bbb'));
//        }
        return true;
    }


    public function results(Request $request) {

        $response = $request->request->get('form');
        $name = $response["name"];
        $place = $response["place"];
        return $name;
    }

    public function getJobsNames($lang = 'pl') {
        $jobs = $this->entityManager->getRepository('App:Jobs')
            ->createQueryBuilder('job')
            ->distinct(true)
            ->select('job.name_'.$lang)
            ->getQuery();

        $array = $jobs->getScalarResult();
        $array = array_column($array, "name_".$lang);
        return array_filter($array);
    }

    public function getCountries($lang = 'pl') {
        $countries = $this->entityManager->getRepository('App:Countries')
            ->createQueryBuilder('countries')
            ->distinct(true)
            ->select('countries.country_'.$lang)
            ->getQuery();

        $array = $countries->getScalarResult();
        $array = array_column($array, "country_".$lang);
        return array_filter($array);
    }

    public function getTaskIds(){
        $ids = $this->entityManager->getRepository('App:Tasks')
            ->createQueryBuilder('id')
            ->distinct(true)
            ->select('id.id')
            ->getQuery();

        $array = $ids->getScalarResult();
        $array = array_column($array, "id");
        return array_filter($array);
    }

    public function getAreas() {
        $areas = $this->entityManager->getRepository('App:Areas')
            ->createQueryBuilder('areas')
            ->distinct(true)
            ->select('areas.area')
            ->getQuery();

        $array = $areas->getScalarResult();
        $array = array_column($array, 'area');
        return array_filter($array);
    }

    public function getCities() {
        $areas = $this->entityManager->getRepository('App:Cities')
            ->createQueryBuilder('cities')
            ->distinct(true)
            ->select('cities.city')
            ->getQuery();

        $array = $areas->getScalarResult();
        $array = array_column($array, 'city');
        return array_filter($array);
    }

    public function getUserIdsOrUsernames($data) {
        $areas = $this->entityManager->getRepository('App:Users')
            ->createQueryBuilder('users')
            ->distinct(true)
            ->select('users.'.$data)
            ->getQuery();

        $array = $areas->getScalarResult();
        $array = array_column($array, $data);
        return array_filter($array);
    }
}