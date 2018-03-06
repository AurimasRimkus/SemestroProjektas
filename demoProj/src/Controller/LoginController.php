<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends AbstractController
{
    public function index()
    {
        return new Response(
            'Prisijungimo puslapis'
        );
    }

    public function show()
    {
        return $this->render('login.html.twig', [

        ]);
    }
}
