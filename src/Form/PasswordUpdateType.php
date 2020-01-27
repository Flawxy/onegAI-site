<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class,
                $this->getConfiguration("Ancient mot de passe", "Votre mot de passe actuel"))
            ->add('newPassword', PasswordType::class,
                $this->getConfiguration("Nouveau mot de passe", "Le mot de passe désiré"))
            ->add('confirmPassword', PasswordType::class,
                $this->getConfiguration("Confirmation", "Confirmez votre mot de passe"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
