<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RegisteredCarsController extends AbstractController
{

    /**
     * @Route("/registeredCars", name="registeredCars")
     */
    public function showAllServices(AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }


        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('registeredCars.html.twig', [
            'users' => $users,
        ]);
    }

}