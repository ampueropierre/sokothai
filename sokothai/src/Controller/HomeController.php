<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    /**
     * @Route("/",name="index_homepage")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message($form->getData()['subject']))
                ->setFrom($form->getData()['mail'])
                ->setTo($this->getParameter('mail_contact'))
                ->setReplyTo($form->getData()['mail'])
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',[
                            'message' => $form->getData()['text'],
                            'name_contact' => $form->getData()['name'],
                            'mail_contact' => $form->getData()['mail'],
                        ]
                    ),
                    'text/html'
                )
                ->addPart(
                    $this->renderView(
                        'emails/contact.txt.twig',[
                            'message' => $form->getData()['text'],
                            'name_contact' => $form->getData()['name'],
                            'mail_contact' => $form->getData()['mail'],
                        ]
                    ),
                    'text/plain'
                )
            ;

            $mailer->send($message);
        }

        return $this->render('homepage/index.html.twig',[
            'events' => $events,
            'form' => $form->createView()
        ]);
    }
}