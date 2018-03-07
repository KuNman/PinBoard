<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 03/03/2018
 * Time: 21:21
 */

namespace App\Service;


use App\Entity\Countries;
use App\Entity\Tasks;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Flex\Response;

class NormalUser
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function searchJobs($lang) {
        $query = $this->entityManager->getRepository('App:Jobs')
            ->createQueryBuilder('jobs')
            ->distinct(true)
            ->select('jobs.name_'.$lang)
            ->getQuery();

        $array = $query->getScalarResult();
        $array = array_column($array, "name_".$lang);
        return $array;
    }

    public function searchCountries($lang = 'en') {
        $query = $this->entityManager->getRepository('App:Countries')
            ->createQueryBuilder('countries')
            ->distinct(true)
            ->select('countries.country_'.$lang)
            ->getQuery();

        $array = $query->getScalarResult();
        $array = array_column($array, "country_".$lang);
        return $array;
    }

    public function searchAreaInCountry($country) {

        $query = $this->entityManager->getRepository('App:Areas')
            ->createQueryBuilder('areas')
            ->distinct(true)
            ->where('areas.country = :country')
            ->setParameter('country', $this->getCountryIdByName($country))
            ->select('areas.area')
            ->getQuery();

        $array = $query->getScalarResult();
        $array = array_column($array, 'area');
        return $array;
    }

    private function getCountryIdByName($country) {
        $query = $this->entityManager->getRepository('App:Countries')
            ->createQueryBuilder('countries')
            ->where('countries.country_en = :country')
            ->setParameter('country', $country)
            ->select('countries.id')
            ->getQuery();

        $array = $query->getSingleResult();
        return $array["id"];

    }

    public function addTask(Request $request, $user_id) {

        $task = new Tasks();
        $task->setJob($this->getJobObject(trim($request->get('job'))));
        $task->setCountry($this->getCountryObject(trim($request->get('country'))));
        $task->setArea($this->getAreaObject(trim($request->get('area'))));
        $task->setCity($request->get('city'));
        $task->setAvaibility(new \DateTime(trim($request->get('date'))));
        $task->setUser($this->getUserObject($user_id));
        $task->setActive(0);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return true;

    }

    private function getJobObject($job) {
        return $this->entityManager->getRepository('App:Jobs')
            ->findOneBy(array("name_pl" => $job));
    }

    private function getCountryObject($country) {
        return $this->entityManager->getRepository('App:Countries')
            ->findOneBy(array('country_en' => $country));
    }

    private function getAreaObject($area) {
        return $this->entityManager->getRepository('App:Areas')
            ->findOneBy(array('area' => $area));
    }

    private function getUserObject($user_id) {
        return $this->entityManager->getRepository('App:Users')
            ->findOneBy(array('id' => $user_id));
    }

}