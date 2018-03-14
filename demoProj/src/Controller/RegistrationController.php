<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    public function index()
    {
        return new Response(
            'Registration page'
        );
    }

    /**
     * @Route("/register", name="register")
     */
    public function show()
    {
        return $this->render('register.html.twig', [

        ]);
    }
}
