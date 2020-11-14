<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/events", name="event_list")
     * @return Response
     */
    public function index()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findByOrderDate();

        return $this->render('admin/event/index.html.twig',[
            'events' => $events
        ]);
    }

    /**
     * @Route("/admin/event", name="event_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $event = new Event();

        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setUser($this->getUser());
            $this->entityManager->persist($event);
            $this->entityManager->flush();

            $this->addFlash('success', 'L\'évènement a bien été créer');

            return $this->redirectToRoute('event_list');
        }

        return $this->render('admin/event/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/event/edit/{id}", name="event_update")
     * @param Event $event
     * @param Request $request
     * @return Response
     */
    public function update(Event $event, Request $request)
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'L\'évènement a bien été modifier');

            return $this->redirectToRoute('event_list');
        }

        return $this->render('admin/event/edit.html.twig',[
            'form' => $form->createView(),
            'event' => $event
        ]);
    }

    /**
     * @Route("/admin/event/delete/{id}", name="event_delete")
     * @param Event $event
     * @return Response
     */
    public function delete(Event $event)
    {
        $this->entityManager->remove($event);
        $this->entityManager->flush();

        $this->addFlash('success', 'l\'évènement a bien été supprimer');

        return $this->redirectToRoute('event_list');
    }
}