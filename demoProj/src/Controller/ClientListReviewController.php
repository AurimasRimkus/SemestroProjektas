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
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
     */
    public function changeIsActive($id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        if ($this->getUser()->getId() == $id){
            return $this->redirectToRoute('clientListReview');
        }

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
		$this->changeUserActiveStatus($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('clientListReview');
    }
	
	public function changeUserActiveStatus($user) {
		$currentActiveStatus = $user->getIsActive();
		$newActiveStatus = !$currentActiveStatus;
		$user->setIsActive($newActiveStatus);
	}

    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     * @codeCoverageIgnore
     */
    public function deleteUser($id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        if ($this->getUser()->getId() == $id){
            return $this->redirectToRoute('clientListReview');
        }

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
		$this->setUserDeleted($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('clientListReview');
    }
	
	public function setUserDeleted ($user) {
		$user->setIsDeleted(true);
	}
	
    /**
     * @Route("/changeRole/{id}/{role}", name="changeRole")
     * @codeCoverageIgnore
     */
    public function setRole($id, $role, AuthorizationCheckerInterface $authChecker){
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        if ($this->getUser()->getId() == $id){
            return $this->redirectToRoute('clientListReview');
        }

        if($this->getUser()->getRole() != 3){
            return $this->redirectToRoute('index');
        }
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setRole($role);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('clientListReview');
    }
}
