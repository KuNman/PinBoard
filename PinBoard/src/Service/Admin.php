<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 25/02/2018
 * Time: 16:06
 */

namespace App\Service;


use App\Entity\Countries;
use App\Entity\Jobs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Admin
{
    private $entityManager;
    private $login;

    public function __construct(EntityManagerInterface $entityManager, Login $login) {
        $this->entityManager = $entityManager;
        $this->login = $login;
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

        if($job) {
            $this->addJob($job);
        }
        if($country) {
            $this->addCountry($country);
        }

        return true;
    }

    private function addJob($job) {
        if(!$this->isJobSaved($job)) {
            $addJob = new Jobs();
            $addJob->setName($job);

            $this->entityManager->persist($addJob);
            $this->entityManager->flush();

            return true;

        }
        return false;
    }

    private function addCountry($country) {
        if(!$this->isCountrySaved($country)) {
            $addCountry = new Countries();
            $addCountry->setCountry($country);

            $this->entityManager->persist($addCountry);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }

    private function isJobSaved($job) {
        return $jobExisting = $this->entityManager->getRepository('App:Jobs')->
        findOneBy(array('name' => $job));
    }

    private function isCountrySaved($country) {
        return $countryExisting = $this->entityManager->getRepository('App:Jobs')->
        findOneBy(array('name' => $country));
    }

}