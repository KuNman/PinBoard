<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 03/03/2018
 * Time: 21:21
 */

namespace App\Service;


use App\Entity\Countries;
use App\Entity\Jobs;
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
        return array_filter($array);
    }

    public function searchCountries($lang = 'en') {
        $query = $this->entityManager->getRepository('App:Countries')
            ->createQueryBuilder('countries')
            ->distinct(true)
            ->select('countries.country_'.$lang)
            ->getQuery();

        $array = $query->getScalarResult();
        $array = array_column($array, "country_".$lang);
        return array_filter($array);
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
        return array_filter($array);
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
        if(!$this->isTaskSaved($request, $user_id)) {

            if(!$this->getJobObject(trim($request->get('job')))) {
                $this->addJobAsUser(trim($request->get('job')));
                $task->setJob($this->getJobObject(trim($request->get('job'))));
            } else {
                $task->setJob($this->getJobObject(trim($request->get('job'))));
            }

            $task->setCountry($this->getCountryObject(trim($request->get('country'))));
            $task->setArea($this->getAreaObject(trim($request->get('area'))));
            $task->setCity($request->get('city'));
            $task->setAvailability(new \DateTime(trim($request->get('date'))));
            $task->setUser($this->getUserObject($user_id));
            $task->setActive(0);

            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return true;
        }
        return false;
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

    private function isTaskSaved(Request $request, $user_id) {

        $task = $this->entityManager->getRepository('App:Tasks')
            ->findOneBy(array(
                'job' => $this->getJobObject(trim($request->get('job'))),
                'country' => $this->getCountryObject(trim($request->get('country'))),
                'area' => $this->getAreaObject(trim($request->get('area'))),
                'availability' => new \DateTime(trim($request->get('date'))),
                'city' => trim($request->get('city')),
                'active' => 0,
                'user' => $this->getUserObject($user_id)
            ));

        return $task ? $task : false;
    }

    private function addJobAsUser($name) {
        $job = new Jobs();
        $job->setNamePl($name);
        $this->entityManager->persist($job);
        $this->entityManager->flush();
        return true;
    }

    public function addUserLangs(Request $request, $user_id) {
       $user = $this->entityManager->getRepository('App:Users')
           ->findOneBy(array('id' => $user_id))->setLangs($request->get('langs'));

       $this->entityManager->flush();
       return true;

    }

    public function getUserlangs($id) {
        $userLangs = $this->entityManager->getRepository('App:Users')
            ->findOneBy(array('id' => $id))->getLangs();

        return $userLangs ? explode(",", $userLangs) : false;
    }

    public function getUserTasks($id) {
        $tasks = $this->entityManager->getRepository('App:Tasks')
            ->findBy(array('user' => $id));

        return $tasks ? $tasks : false;
    }

    public function getUserEmail($id) {
        $email = $this->entityManager->getRepository('App:Users')
            ->findOneBy(array('id' => $id))->getUsername();

        return $email ? $email : false;
    }

}