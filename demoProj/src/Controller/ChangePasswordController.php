<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class ChangePasswordController extends AbstractController
{
    public function index()
    {
        return new Response(
            'Change password'
        );
    }

    public function show()
    {
        return $this->render('changePassword.html.twig', [

        ]);
    }
}
