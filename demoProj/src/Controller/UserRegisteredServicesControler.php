<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Repair;
use App\Entity\User;
use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserRegisteredServicesControler extends AbstractController
{

    /**
     * @Route("/userRegisteredServices", name="userRegisteredServices")
     */
    public function userRegisteredServices(AuthorizationCheckerInterface $authChecker)
    {

        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('userRegisteredOrders.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/showUserServices/{id}", name="showUserServices")
     */
    public function showUserServices($id)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        $repairs = $this->getDoctrine()->getManager()->getRepository(Repair::class)->findAll();
        return $this->render('userRegisteredServicesList.html.twig', array(
            'order' => $order,
            'repairs'=>$repairs,
        ));
    }



}