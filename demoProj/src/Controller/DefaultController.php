<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package App\Controller
 * @codeCoverageIgnore
 */
class DefaultController extends AbstractController
{
    public function index()
    {

        return new Response(
            'Main page'
        );
    }

    public function show()
    {
        if($this->getUser() != null){
            $em = $this->getDoctrine()->getManager();
            $this->getUser()->setLastLoginTime(new \DateTime());
            $em->flush();
        }
        return $this->render('index.html.twig', [
            'services' => ($this->getDoctrine()->getRepository(Service::class)
                    ->findAll() != null)? true:false
        ]);
    }
}
