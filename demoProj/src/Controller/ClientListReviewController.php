<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ClientListReviewController extends Controller
{
    /**
     * @Route("/clientListReview", name="clientListReview")
     */
    public function showAllClients(AuthorizationCheckerInterface $authChecker, Request $request)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT u
            FROM App\Entity\User u
            WHERE  u.isDeleted = false'
        );

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->get('page',1),
            5 //limit per page
        );

        return $this->render('clientListReview.html.twig', [
            'users' => $result,
        ]);
    }


    /**
     * @Route("/changeIsActive/{id}", name="changeIsActiveUserType")
     */
    public function changeIsActive($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setIsActive(!$user->getIsActive());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('clientListReview');
    }

    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     */
    public function deleteUser($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setIsDeleted(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('clientListReview');
    }
    /**
     * @Route("/changeRole/{id}/{role}", name="changeRole")
     */
    public function setRole($id, $role){
        if($this->getUser()->getRole() != 3){
            return $this->redirectToRoute('index');
        }
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setRole($role);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('clientListReview');
    }
}
