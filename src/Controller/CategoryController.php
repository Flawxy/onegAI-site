<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\DocumentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * Permet de créer une nouvelle catégorie dans la documentation
     *
     * @Route("/cat/new", name="cat_create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        if($this->getUser()) {

            $category = new Category();

            $form = $this->createForm(CategoryType::class, $category);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($category);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "La catégorie <strong>{$category->getName()}</strong> a bien été ajoutée à la documentation !"
                );

                return $this->redirectToRoute('doc_index', [
                    '_fragment' => 'category' . $category->getId()
                ]);
            }

            return $this->render('category/new.html.twig', [
                'catForm' => $form->createView()
            ]);
        }else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * Permet d'afficher le formulaire d'édition
     *
     * @Route("/cat/{id}/edit", name="cat_edit")
     */
    public function edit(Request $request, Category $category, EntityManagerInterface $manager)
    {
        if($this->getUser()) {

            $form = $this->createForm(CategoryType::class, $category);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($category);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "La catégorie <strong>{$category->getName()}</strong> a bien été modifiée !"
                );

                return $this->redirectToRoute('doc_index', [
                    '_fragment' => 'category' . $category->getId()
                ]);
            }

            return $this->render('category/edit.html.twig', [
                'catForm' => $form->createView(),
                'category' => $category
            ]);
        }else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * Permet de supprimer un article
     *
     *@Route("/cat/{id}/delete", name="cat_delete")
     */
    public function delete(DocumentationRepository $repo, Category $category, EntityManagerInterface $manager)
    {
        if($this->getUser()) {

            if($repo->findOneBy(['category' => $category->getId()])) {

                $this->addFlash(
                    'danger',
                    "La catégorie <strong>{$category->getName()}</strong> n'a pas été supprimée car elle n'est pas vide !"
                );

                return $this->redirectToRoute('doc_index');

            }else {

                $manager->remove($category);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "La catégorie <strong>{$category->getName()}</strong> a bien été supprimée !"
                );

                return $this->redirectToRoute('cat_index');
            }
        }else {

            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * Permet d'afficher la liste des catégories
     *
     * @Route("/cat/index", name="cat_index")
     */
    public function index(CategoryRepository $repo)
    {
        if($this->getUser()) {

            $entries = $repo->findBy(array(), array('id' => 'ASC'));

            return $this->render('category/index.html.twig', [
                'categories' => $entries
            ]);

        }else {
            return $this->redirectToRoute('homepage');
        }
    }
}
