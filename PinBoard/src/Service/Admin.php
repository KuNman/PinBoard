<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 25/02/2018
 * Time: 16:06
 */

namespace App\Service;


use App\Entity\Areas;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\Jobs;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Flex\Response;

class Admin
{
    private $entityManager;
    private $login;
    private $mailer;
    private $normalUser;

    public function __construct(EntityManagerInterface $entityManager, Login $login,
                                Mail $mailer, NormalUser $normalUser) {
        $this->entityManager = $entityManager;
        $this->login = $login;
        $this->mailer = $mailer;
        $this->normalUser = $normalUser;
    }

    public function isAdmin($username) {

        if($this->login->isLogged()) {
            $admin = $this->entityManager->getRepository('App:Users')->findOneBy(array("username" => $username))->getRole();
            if($admin == 'admin') {
                return true;
            }
        }
        return false;
    }

    public function addTask(Request $request) {
        $job = $request->get('job');
        $country = $request->get('country');
        $area = $request->get('area');
        $city = $request->get('city');

        if($job) {
            $this->addJob($job);
        }
        if($country) {
            $this->addCountry($country);
        }
        if($area) {
            $this->addArea($area, $country);
        }
        if($city) {
            $this->addCity($city, $area, $country);
        }

        return true;
    }

    public function addNewJobName(Request $request) {
        $name_en = $request->get('new_job_en');
        $name_pl = $request->get('new_job_pl');
        $name_fr = $request->get('new_job_fr');

        if(!$this->isJobSaved($name_en) && $name_fr && $name_pl) {
            $addJob = new Jobs();
            $addJob->setNameEn($name_en);
            $addJob->setNamePl($name_pl);
            $addJob->setNameFr($name_fr);

            $this->entityManager->persist($addJob);
            $this->entityManager->flush();

            return true;

        }
        return false;
    }

    public function addNewCountryName(Request $request) {
        $name_en = $request->get('new_country_en');
        $name_pl = $request->get('new_country_pl');
        $name_fr = $request->get('new_country_fr');
        if(!$this->isCountrySaved($name_en) && $name_fr && $name_pl) {
            $addCountry = new Countries();
            $addCountry->setCountryEn($name_en);
            $addCountry->setCountryPl($name_pl);
            $addCountry->setCountryFr($name_fr);

            $this->entityManager->persist($addCountry);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }

    public function addNewAreaName(Request $request) {
        $area = $request->get('area');
        $country = $request->get('country');

        if(!$this->isAreaInCountrySaved($area, $country)) {
            $country = $this->entityManager->getRepository(Countries::class)
                ->findOneBy(array('country_en' => $country));

            $addArea = new Areas();
            $addArea->setArea($area);
            $addArea->setCountry($country);

            $this->entityManager->persist($addArea);
            $this->entityManager->flush();

            return true;

        }
        $cities = $this->entityManager->getRepository('App:Cities')
            ->findOneBy(array('country' => 1));
    }

    private function addCity($city, $area, $country) {
        if(!$this->isCityInAreaSaved($city, $area,$country)) {
            $area = $this->entityManager->getRepository('App:Areas')
                ->findOneBy(array('area' => $area));

            $country = $this->entityManager->getRepository('App:Countries')
                ->findOneBy(array('country' => $country));

            $addCity = new Cities();
            $addCity->setCity($city);
            $addCity->setArea($area);
            $addCity->setCountry($country);

            $this->entityManager->persist($addCity);
            $this->entityManager->flush();

            return true;
        }
        
    }

    private function isJobSaved($name_en) {
        return $jobExisting = $this->entityManager->getRepository('App:Jobs')->
            findOneBy(array('name_en' => $name_en));
    }

    private function isCountrySaved($name_en) {
        return $countryExisting = $this->entityManager->getRepository('App:Countries')->
            findOneBy(array('country_en' => $name_en));
    }

    private function isAreaInCountrySaved($area, $country) {

        $country = $this->entityManager->getRepository('App:Countries')
            ->findOneBy(array('country_en' => $country));

        $areaInCountry = $this->entityManager->getRepository('App:Areas')
            ->findOneBy(array('area' => $area, 'country' => $country));

        if($areaInCountry) {
            return true;
        }

        return false;
    }

    private function isCityInAreaSaved($city, $area, $country) {

        $area = $this->entityManager->getRepository('App:Areas')
            ->findOneBy(array('area' => $area));

        $country = $this->entityManager->getRepository('App:Countries')
            ->findOneBy(array('country' => $country));

        $cityInArea = $this->entityManager->getRepository('App:Cities')
            ->findOneBy(array('city' => $city, 'area' => $area, 'country' => $country));

        if($cityInArea) {
            return true;
        }

        return false;
    }

    public function checkMissingJobNameEn() {
        $arr = [];
        $missingNames = $this->entityManager->getRepository('App:Jobs')
            ->findBy(array('name_en' => null));

        foreach ($missingNames as $name) {
            $arr[] = $name->getNamePl();

        }
        if($arr) {
            return $arr;
        }
        return false;
    }

    public function checkMissingJobNameFr() {
        $arr = [];
        $missingNames = $this->entityManager->getRepository('App:Jobs')
            ->findBy(array('name_fr' => null));

        foreach ($missingNames as $name) {
            $arr[] = $name->getNamePl();

        }
        if($arr) {
            return $arr;
        }
        return false;

    }

    public function addJobEnName(Request $request) {
        $this->entityManager->getRepository('App:Jobs')
            ->findOneBy(array("name_pl" => trim($request->get('name_pl'))))
            ->setNameEn(trim($request->get('name_en')));

        $this->entityManager->flush();
        return true;
    }

    public function addJobFrName(Request $request) {
        $this->entityManager->getRepository('App:Jobs')
            ->findOneBy(array("name_pl" => trim($request->get('name_pl'))))
            ->setNameFr(trim($request->get('name_fr')));

        $this->entityManager->flush();
        return true;
    }

    public function checkNotActiveTasks() {
        $notActiveTasks = $this->entityManager->getRepository('App:Tasks')
            ->findBy(array("active" => false));


        if($notActiveTasks) {
            return $notActiveTasks;
        }
        return false;
    }

    public function activateTask($id, $userId) {
        $this->entityManager->getRepository('App:Tasks')
            ->findOneBy(array('id' => $id, 'user' => $userId))->setActive(1);
        $this->entityManager->flush();

        $this->sendNotificationMailToUser($userId, 'notifyTaskActive');

        return true;
    }

    public function deactivateTask($id, $userId) {
        $this->entityManager->getRepository('App:Tasks')
            ->findOneBy(array('id' => $id, 'user' => $userId))->setActive(0);
        $this->entityManager->flush();

        $this->sendNotificationMailToUser($userId, 'notifyTaskDeactive');
        return true;
    }

    public function sendNotificationMailToUser($id, $action) {
        $mail = $this->entityManager->getRepository('App:Users')
            ->findOneBy(array('id' => $id))->getUsername();

        if($mail) {
            switch($action) {
                case 'notifyTaskActive':
                    $this->mailer->sendMail('Task active', $mail, 'Your task is active!');
                    break;
                case 'notifyTaskDeactive':
                    $this->mailer->sendMail('Task deactivated', $mail, 'Your task is deactivated!');
                    break;
                case 'notifyTaskRemoved':
                    $this->mailer->sendMail('Task removed', $mail, 'Your task is removed!');
                    break;
                case 'notifyOrderFound':
                    echo 'aaa';
                    break;
            }
            return true;
        }
        return false;

    }

    public function allTasks() {
        $tasks = $this->entityManager->getRepository('App:Tasks')
            ->findAll();
        return $tasks ? $tasks : false;
    }

    public function removeTask($id) {
        $task = $this->entityManager->getRepository('App:Tasks')
            ->findOneBy(array('id' => $id));

        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return true;
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

}