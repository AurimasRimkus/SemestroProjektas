<?php

namespace App\Controller;

use App\Entity\Repair;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CarServicesController extends AbstractController
{

    /**
     * @Route("/changeIsDone/{id}", name="changeIsDone")
     */
    public function changeIsDone($id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $repair = $this->getDoctrine()->getRepository(Repair::class)->find($id);
        $orderId = $repair->getOrder()->getId();
        $repair->setIsDone(true);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect('/showServices/' . $orderId);
    }
}
