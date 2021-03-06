<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Documentation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('command', TextType::class,
                $this->getConfiguration("Nom de la commande",
                "Le nom complet de la commande ([5-255] caractères)"))
            ->add('syntax', TextType::class,
                $this->getConfiguration("Syntaxe de la commande",
                "Syntaxe de la commande (3 caractères minimum)"))
            ->add('shortcut', TextType::class,
                $this->getConfiguration("Raccourci de la commande",
                "Raccourci de la commande (2 caractères minimum)"))
            ->add('description', TextareaType::class,
                $this->getConfiguration("Description de la commande",
                "La description détaillée de la commande (50 caractères minimum)"))
            ->add('example', TextType::class,
                $this->getConfiguration("Exemple",
                "Un exemple d'utilisation de la commande (6 caractères minimum)"))
            ->add('category', EntityType::class, [
                'label' => "Catégorie de l'entrée",
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('wip', CheckboxType::class, [
                'label' => "Cocher si la commande n'est pas encore fonctionnelle (WIP)",
                'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Documentation::class,
        ]);
    }
}
