<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ServiceTypesController extends AbstractController
{
    /**
     * @Route("/editServiceTypes", name="editServiceTypes")
     */
    public function showAllServices()
    {
        $services = $this->getDoctrine()->getManager()->getRepository(Service::class)->findAll();
        return $this->render('editServiceTypes.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/changeServiceType/{id}", name="changeServiceType")
     */
    public function changeServiceType(Request $request, $id)
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
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
    public function addServiceType(Request $request)
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
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
    public function changeIsActive($id)
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $service->setIsActive(!$service->getIsActive());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('editServiceTypes');
    }

    /**
     * @Route("/deleteServiceType/{id}", name="deleteServiceType")
     */
    public function deleteServiceType($id)
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $this->getDoctrine()->getManager()->remove($service);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('editServiceTypes');
    }
}
