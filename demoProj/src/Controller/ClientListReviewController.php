<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ClientListReviewController extends AbstractController
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
