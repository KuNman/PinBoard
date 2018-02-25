<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 25/02/2018
 * Time: 16:06
 */

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class Admin
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function isAdmin() {

        $session = new Session();
        $username = $session->get('username');
        $admin = $this->entityManager->getRepository('App:Users')->findOneBy(array("username" => $username))->getRole();

        if($admin == 'admin') {
            return true;
        }
        return false;
    }

}