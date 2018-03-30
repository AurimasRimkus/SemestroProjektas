<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
    	$em = $this->getDoctrine()->getManager();
        $this->getUser()->setLastLoginTime(new DateTime());
        $em->flush();
        return $this->render('main/main.html.twig', [
        ]);
    }
}
