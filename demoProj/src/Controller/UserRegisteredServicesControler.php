<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Repair;
use App\Entity\User;
use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserRegisteredServicesControler extends Controller
{

    /**
     * @Route("/userRegisteredServices", name="userRegisteredServices")
     */
    public function userRegisteredServices(AuthorizationCheckerInterface $authChecker, Request $request)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $userId = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT o.startDate, c.model, o.id
            FROM App\Entity\Order o
              LEFT JOIN o.profile p
              LEFT JOIN o.car c
            WHERE p.user = :user'
        )->setParameter('user', $userId);

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->get('page',1),
            5
        );

        return $this->render('userRegisteredOrders.html.twig', [
            'services' => $result,
        ]);
    }

    /**
     * @Route("/showUserServices/{id}", name="showUserServices")
     */
    public function showUserServices($id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        $repairs = $this->getDoctrine()->getManager()->getRepository(Repair::class)->findAll();
        return $this->render('userRegisteredOrdersList.html.twig', array(
            'order' => $order,
            'repairs'=>$repairs,
        ));
    }



}