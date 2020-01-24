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

class DocumentationType extends AbstractType
{

    /**
     * Permet d'avoir la configuration de base d'un champ du formulaire
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    public function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('command', TextType::class, $this->getConfiguration("Nom de la commande",
                "Le nom complet de la commande"))
            ->add('syntax', TextType::class, $this->getConfiguration("Syntaxe de la commande",
                "Syntaxe de la commande"))
            ->add('shortcut', TextType::class, $this->getConfiguration("Raccourci de la commande",
                "Raccourci de la commande"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description de la commande",
                "La description détaillée de la commande"))
            ->add('example', TextType::class, $this->getConfiguration("Exemple",
                "Un exemple d'utilisation de la commande"))
            ->add('category', EntityType::class, [
                'label' => "Catégorie de l'entrée",
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('wip', CheckboxType::class, [
                'label' => "Cocher si la commande n'est pas encore fonctionnelle",
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
