<?php
namespace App\Controller;
use App\Entity\Services;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class BoardController extends Controller
{
    /**
     * @Route("/")
     * @
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository(Service::class)->findAll();

        return $this->render('index.html.twig', array(
            'categories' => $categories,
        ));
    }

}
?>