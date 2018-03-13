<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class RegistrationController extends AbstractController
{
    public function index()
    {
        return new Response(
            'Registration page'
        );
    }

    public function show()
    {
        return $this->render('register.html.twig', [

        ]);
    }
}
