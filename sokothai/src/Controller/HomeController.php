<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $events = $this->getDoctrine()->getRepository(Event::class)->findAllCreatedAtBeforeOrAfter(new \DateTime(), false);

        $form = $this->createForm(ContactType::class);

        return $this->render('homepage/index.html.twig',[
            'events' => $events,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("contact/ajax", name="ajax-mail")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return JsonResponse
     */
    public function ajaxMail(Request $request, \Swift_Mailer $mailer)
    {
        $dataPost = $request->request->all();

        $form = $this->createForm(ContactType::class,$dataPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = [];

            foreach ($form->getErrors(true) as $error) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errors], 403);

        }

        $this->sendMail($dataPost['contact'], $mailer);

        $response = 'true';

        return new JsonResponse(['response' => $response], 200);
    }

    /**
     * @param array $data
     * @param \Swift_mailer $mailer
     */
    private function sendMail(array $data, \Swift_mailer $mailer)
    {
        $message = (new \Swift_Message($data['subject']))
            ->setFrom($data['mail'])
            ->setTo($this->getParameter('mail_contact'))
            ->setReplyTo($data['mail'])
            ->setBody(
                $this->renderView(
                    'emails/contact.html.twig',[
                        'message' => $data['text'],
                        'name_contact' => $data['name'],
                        'mail_contact' => $data['mail'],
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->renderView(
                    'emails/contact.txt.twig',[
                        'message' => $data['text'],
                        'name_contact' => $data['name'],
                        'mail_contact' => $data['mail'],
                    ]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);

    }
}