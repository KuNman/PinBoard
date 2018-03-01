<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 25/02/2018
 * Time: 16:06
 */

namespace App\Service;


use App\Entity\Areas;
use App\Entity\Countries;
use App\Entity\Jobs;
use Doctrine\Common\Collections\ArrayCollection;
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
        $area = $request->get('area');

        if($job) {
            $this->addJob($job);
        }
        if($country) {
            $this->addCountry($country);
        }
        if($area) {
            $this->addArea($area, $country);
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

    private function addArea($area, $country) {
//        if(!$this->isAreaSaved($area)) {

            $countryId = $this->entityManager->getRepository(Countries::class)
                ->findOneBy(array('country' => $country));

            $addArea = new Areas();
            $addArea->setArea($area);
            $addArea->setCountry($countryId);

            $this->entityManager->persist($addArea);
            $this->entityManager->flush();

            return true;

//        }
        return false;
    }

    private function isJobSaved($job) {
        return $jobExisting = $this->entityManager->getRepository('App:Jobs')->
            findOneBy(array('name' => $job));
    }

    private function isCountrySaved($country) {
        return $countryExisting = $this->entityManager->getRepository('App:Countries')->
            findOneBy(array('country' => $country));
    }

    private function isAreaSaved($area) {
        return $areaExisting = $this->entityManager->getRepository('App:Areas')->
            findOneBy(array('area' => $area));
    }

    public function query($area, $country) {
        $product = $this->entityManager->getRepository('App:Areas')->findBy(['country' => 12, 'area' => 'Poprad']);
        if($product) {
            echo 'jest';
        }

    }

}