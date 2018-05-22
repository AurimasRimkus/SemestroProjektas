<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ServiceTypesController extends Controller
{
    /**
     * @Route("/editServiceTypes", name="editServiceTypes")
     */
    public function showAllServices(AuthorizationCheckerInterface $authChecker, Request $request)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT s
            FROM App\Entity\Service s'
        );

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->get('page',1),
            5 //limit per page
        );

        return $this->render('editServiceTypes.html.twig', [
            'services' => $result,
        ]);
    }

    /**
     * @Route("/changeServiceType/{id}", name="changeServiceType")
     */
    public function changeServiceType(Request $request, $id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $serviceName = $service->getName();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $foundService = $this->getDoctrine()->getRepository(Service::class)
                ->findOneBy(['name'=>$form->get('name')->getData()]);
            if ($foundService !== null && $foundService->getName() != $serviceName)
            {
                return $this->render('editServiceType.html.twig', array(
                    'form' => $form->createView(),
                    'action' => "Edit",
                    'error'=>"Service with this name already exist."
                ));
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('editServiceTypes');
        }

        return $this->render('editServiceType.html.twig', array(
            'form' => $form->createView(),
            'action' => "Edit",
        ));
    }

    /**
     * @Route("/addServiceType", name="addServiceType")
     */
    public function addServiceType(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $foundService = $this->getDoctrine()->getRepository(Service::class)->findOneBy(['name'=>$service->getName()]);
            if($foundService)
            {
                return $this->render('editServiceType.html.twig', array(
                    'form'=>$form->createView(),
                    'error'=>"This service type already exist.",
                    'action' => "Add",
                ));
            }
            $em = $this->getDoctrine()->getManager();

            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('editServiceTypes');
        }

        return $this->render('editServiceType.html.twig', array(
            'form'=>$form->createView(),
            'action' => "Add",
        ));
    }

    /**
     * @Route("/changeIsActiveServiceType/{id}", name="changeIsActiveServiceType")
     */
    public function changeIsActive($id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $service->setIsActive(!$service->getIsActive());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('editServiceTypes');
    }

    /**
     * @Route("/deleteServiceType/{id}", name="deleteServiceType")
     */
    public function deleteServiceType($id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $this->getDoctrine()->getManager()->remove($service);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('editServiceTypes');
    }
}
