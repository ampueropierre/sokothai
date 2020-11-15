<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'Email',
                'constraints' => [
                    new Email(['message' => 'Le mail n\'est pas valide']),
                    new NotBlank(['message' => 'Le champ ne peut etre vide'])
                ],
                'translation_domain' => false
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe',
                'required' => false,
                'translation_domain' => false
            ])
        ;
    }
}