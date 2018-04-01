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
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Tasks;

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
            ->add('job', TextType::class)
            ->add('place', TextType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        return $form->createView() ? $form->createView() : false;
    }

    public function defineLang(Request $request)
    {
        if (!isset($_COOKIE['lang'])) {
            $lang = $request->getLocale();
            switch ($lang) {
                case $lang == 'en':
                case $lang == 'pl':
                case $lang == 'fr':
                    setcookie('lang', $lang, strtotime('now + 1 day'));
                    break;
                default:
                    setcookie('lang', 'en', strtotime('now + 1 day'));
            }
        }
        return true;
    }


    public function results(Request $request) {
        $job =  $request->get('form')['job'];
        $place =  $request->get('form')['place'];
        return $request ? $this->isTaskAvailable($job, $this->formatAddress($place), $_COOKIE['lang']) : false;
    }

    private function formatAddress($address) {
        $array = explode(",",$address);
        if(count($array) == 3) {
            unset($array[1]);
        }
        foreach ($array as $value) {
            $arrayFormatted[] = strip_tags($value);
        }
        return $arrayFormatted;
    }

    private function isTaskAvailable($job, $place, $lang) {
        $job = trim($job);
        $city = trim(preg_replace('/[0-9 -]+/', '', $place[0]));
        $country = trim(preg_replace('/[0-9 -]+/', '', $place[1]));

        if($this::isSearchStringValid($job) &&
           $this::isSearchStringValid($city) &&
           $this::isSearchStringValid($country)) {
            return $this->searchTaskInDB($job, $city, $country, $lang);
        }
    }

    private function searchTaskInDB($job, $city, $country, $lang) {
        $jobId = $this->getJobIdByName($job, $lang);
        $countryId = $this->getCountryIdByName($country, $lang);

        if($jobId && $countryId) {
            $tasks = $this->entityManager->getRepository('App:Tasks')
                ->createQueryBuilder('tasks');

            $tasks->andWhere("tasks.job = $jobId");
            $tasks->andWhere("tasks.country = $countryId");

            $tasks = $tasks->getQuery()->getResult();
            $pattern = "/" . preg_quote($city, "/") . "/";

            foreach ($tasks as $task) {
                if($task->getCity() === 'wholeArea' || preg_match($pattern, $task->getCity())) {
                    $tasksArray[] = $task;
                }
            }
            return $tasksArray;
        }
        return false;
    }

    private function getJobIdByName($job, $lang) {
        $job = $this->entityManager->getRepository('App:Jobs')
            ->findOneBy(array("name_".$lang => $job));
        return $job ? $job->getId() : false;
    }

    private function getCountryIdByName($country, $lang) {
        $country = $this->entityManager->getRepository('App:Countries')
            ->findOneBy(array("country_fr" => $country));
        return $country ? $country->getId() : false;
    }

    public function getJobsNames($lang = 'pl') {
        $jobs = $this->entityManager->getRepository('App:Jobs')
            ->createQueryBuilder('job')
            ->distinct(true)
            ->select('job.name_'.$lang)
            ->getQuery();

        $array = $jobs->getScalarResult();
        $array = array_column($array, "name_".$lang);
        return array_filter($this::remapArrayAfterRemovingNulls($array));
    }

    public function getCountries($lang = 'pl') {
        $countries = $this->entityManager->getRepository('App:Countries')
            ->createQueryBuilder('countries')
            ->distinct(true)
            ->select('countries.country_'.$lang)
            ->getQuery();

        $array = $countries->getScalarResult();
        $array = array_column($array, "country_".$lang);
        return array_filter($this::remapArrayAfterRemovingNulls($array));
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

    private static function isSearchStringValid($string) {
        return preg_match('/^[\p{L}-. ]*$/u', $string) ? true : false;
    }

    private static function remapArrayAfterRemovingNulls($array) {
        $arrayRemapped = array();
        foreach ($array as $row) {
            if ($row !== null)
                $arrayRemapped[] = $row;
        }
        return $arrayRemapped ? $arrayRemapped : false;
    }
}