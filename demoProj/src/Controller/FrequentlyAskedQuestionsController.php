<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrequentlyAskedQuestionsController extends AbstractController
{
    public function index()
    {
        return new Response(
            'FAQ page'
        );
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function show()
    {
        return $this->render('FAQ.html.twig', [

        ]);
    }
}
