<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class BoardController extends Controller
{
    /**
     * @Route("/*")
     * @
     */
    public function index()
    {

        $categories = 'aaa';

        return $this->render('index.html.twig');

    }
}
?>