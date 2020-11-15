<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index_homepage');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/admin/user/edit/{id}", name="user_update")
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function edit(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserEditType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataUser = $form->getData();
            $message='';

            if($user->getEmail() != $dataUser['email'] && $dataUser['password']) {
                $user->setEmail($dataUser['email']);
                $user->setPassword($passwordEncoder->encodePassword($user,$dataUser['password']));
                $message = 'Votre email et motre de passe ont bien été modifiés';
            } elseif ($user->getEmail() != $dataUser['email']) {
                $user->setEmail($dataUser['email']);
                $message = 'Votre email a bien été modifié';
            } elseif ($dataUser['password']) {
                $user->setPassword($passwordEncoder->encodePassword($user,$dataUser['password']));
                $message = 'Votre motre de passe a bien été modifié';
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', $message);
        }

        return $this->render('admin/user/edit.html.twig',[
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

    }
}
