<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Nom ne peut être vide']),
                ],
                'attr' => [
                    'placeholder' => '* Votre nom'
                ],
                'translation_domain' => false
            ])
            ->add('mail', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Email ne peut être vide']),
                    new Email(['message' => 'Adresse Email non valide'])
                ],
                'attr' => [
                    'placeholder' => '* Votre email'
                ],
                'translation_domain' => false
            ])
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Information Général' => 'Information Général',
                    'Réservation' => 'Réservation',
                    'Privatisation Devis' => 'Privatisation Devis',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le champ ne peut être vide']),
                ],
                'translation_domain' => false
            ])
            ->add('text', TextareaType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ message ne peut être vide']),
                    new Length(['min' => 3,'minMessage' => 'Minimum de 3 caractères']),
                ],
                'attr' => [
                    'placeholder' => '* Votre message'
                ],
                'translation_domain' => false
            ])
        ;
    }
}