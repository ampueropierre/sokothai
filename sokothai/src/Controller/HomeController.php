<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    /**
     * @Route("/",name="index_homepage")
     *
     * @return Response
     */
    public function index()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('homepage/index.html.twig',[
            'events' => $events
        ]);
    }
}