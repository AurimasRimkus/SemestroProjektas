<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class TermsOfServiceController extends AbstractController
{
    public function index()
    {
        return new Response(
            'TOS page'
        );
    }

    public function show()
    {
        return $this->render('TOS.html.twig', [

        ]);
    }
}
