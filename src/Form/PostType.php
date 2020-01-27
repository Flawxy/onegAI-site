<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre",
                "Le titre de l'article"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction",
                "La phrase d'accroche de l'article"))
            ->add('content', TextareaType::class, $this->getConfiguration("Contenu",
                "Le contenu de l'article"))
            ->add('image', UrlType::class, $this->getConfiguration("Image",
                "L'adresse de l'image de présentation de l'article"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
