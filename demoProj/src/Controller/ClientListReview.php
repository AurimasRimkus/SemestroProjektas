<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ClientListReview extends AbstractController
{
    /**
     * @Route("/clientListReview", name="clientListReview")
     */
    public function showAllClients()
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('clientListReview.html.twig', [
            'users' => $users,
        ]);
    }
}
