<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ChangePasswordController extends AbstractController
{
    public function index()
    {
        return new Response(
            'Change password'
        );
    }

    /**
    * @Route("/changePassword", name="changePassword")
    */
    public function show()
    {
        return $this->render('changePassword.html.twig', [

        ]);
    }
}
