<?php

namespace App\Controller;

use App\Entity\Repair;
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
    public function changeIsDone($id)
    {
        $repair = $this->getDoctrine()->getRepository(Repair::class)->find($id);
        $repair->setIsDone(!$repair->getIsDone());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('editCarServices');
    }
}
