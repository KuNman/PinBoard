<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 25/02/2018
 * Time: 16:06
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\Session\Session;

class Admin
{
    private $entityManager;

    public function __construct() {
    }

    public function isAdmin() {
        $session = new Session();
        $session->set('username', 'admin');
        if($session->get('username')) {
            return true;
        }
        return false;
    }

}