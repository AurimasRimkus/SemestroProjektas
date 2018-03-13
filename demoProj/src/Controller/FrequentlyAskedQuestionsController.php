<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class FrequentlyAskedQuestionsController extends AbstractController
{
    public function index()
    {
        return new Response(
            'FAQ page'
        );
    }

    public function show()
    {
        return $this->render('FAQ.html.twig', [

        ]);
    }
}
