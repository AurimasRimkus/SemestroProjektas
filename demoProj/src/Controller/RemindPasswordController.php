<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RemindPasswordController extends AbstractController
{
    public function index()
    {
        return new Response(
            'Remind password page'
        );
    }

    /**
     * @Route("/remindPassword", name="remindPassword")
     */
    public function show()
    {
        return $this->render('remindPassword.html.twig', [

        ]);
    }
}
