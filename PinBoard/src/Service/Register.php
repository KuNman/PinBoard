<?php
/**
 * Created by PhpStorm.
 * User: kn
 * Date: 22/02/2018
 * Time: 19:34
 */

namespace App\Service;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder;


class Register
{
    private $entityManager;
    private $encoder;

    public function __construct(EntityManagerInterface $entityManager, Encoder\UserPasswordEncoderInterface $encoder) {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    public function form(Request $request) {

        $formFactory = Forms::createFormFactory();

        $form = $formFactory->createBuilder()
            ->setAction('/')
            ->setMethod('POST')
            ->add('username', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('submit', ButtonType::class, array(
                'attr' => array('disabled' => true),
            ))
            ->getForm();

        return $form->createView() ? $form->createView() : false;
    }

    public function checkUserNameAvaibility($username) {

        $check = $this->entityManager->getRepository('App:Users')->findOneBy(array('username' => $username));

        //false = user exists
        //true = method passed
        return $check ? false : true;

    }

    public function addNewUser($username, $password) {
        if(self::validateUsername($username) && self::validatePassword($password)) {
            $user = new Users();
            $user->setUsername($username);
            $hashed = $this->encoder->encodePassword($user, $password);
            $user->setPassword($hashed);
            $user->setRole('user');
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return true;
        }
    }

    static function validateUsername($username) {
        return preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $username) ? true : false;
    }

    static function validatePassword($password) {
        return (strlen($password) >= 6) ? true : false;
    }



}