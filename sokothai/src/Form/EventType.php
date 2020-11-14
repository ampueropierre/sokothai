<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank(['message' => 'Le titre ne peut être vide'])
                ],
                'translation_domain' => false
            ])
            ->add('url_facebook', UrlType::class,[
                'label' => 'Lien Facebook',
                'constraints' => [
                    new Url(['message' => 'Le lien n\'est pas une URL valide'])
                ],
                'translation_domain' => false
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de l\'évènement',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
                'html5' => false,
                'attr'=> [
                    'placeholder' => "Date de la mission"
                ],
                'translation_domain' => false
            ])
            ->add('isActived', CheckboxType::class,[
                'label' => 'Statut',
                'required' => false,
                'translation_domain' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}