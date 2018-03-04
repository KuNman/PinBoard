<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 03/03/2018
 * Time: 21:21
 */

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Flex\Response;

class NormalUser
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function searchJobs() {
        $query = $this->entityManager->getRepository('App:Jobs')
            ->createQueryBuilder('jobs')
            ->distinct(true)
            ->select('jobs.name_pl')
            ->getQuery();

        $array = $query->getScalarResult();
        $array = array_column($array, "name_pl");
        return $array;
    }

    public function searchCountries() {
        $query = $this->entityManager->getRepository('App:Countries')
            ->createQueryBuilder('countries')
            ->distinct(true)
            ->select('countries.country_pl')
            ->getQuery();

        $array = $query->getScalarResult();
        $array = array_column($array, "country_pl");
        return $array;
    }

}