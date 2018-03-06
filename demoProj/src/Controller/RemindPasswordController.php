<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class RemindPasswordController extends AbstractController
{
    public function index()
    {
        return new Response(
            'Remind password page'
        );
    }

    public function show()
    {
        return $this->render('remindPassword.html.twig', [

        ]);
    }
}
