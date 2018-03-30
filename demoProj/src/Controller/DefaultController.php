<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends AbstractController
{
    public function index()
    {
        return new Response(
            'Main page'
        );
    }

    public function show()
    {
        if($this->getUser() != null){
            $em = $this->getDoctrine()->getManager();
            $this->getUser()->setLastLoginTime(new \DateTime());
            $em->flush();
        }
        return $this->render('index.html.twig', [

        ]);
    }
}
