<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TermsOfServiceController
 * @package App\Controller
 * @codeCoverageIgnore
 */
class TermsOfServiceController extends AbstractController
{
    public function index()
    {
        return new Response(
            'TOS page'
        );
    }

    /**
     * @Route("/tos", name="tos")
     */
    public function show()
    {
        return $this->render('TOS.html.twig', [

        ]);
    }
}
