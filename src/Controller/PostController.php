<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * Affiche tous les articles de la BDD
     *
     * @Route("/posts", name="posts_index")
     */
    public function index(PostRepository $repo)
    {
        $posts = $repo->findBy(array(), array('createdAt' => 'DESC'));

        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * Permet de créer un article
     *
     * @Route("/posts/new", name="posts_create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong>{$post->getTitle()}</strong> a bien été publié !"
            );

            return $this->redirectToRoute('posts_show', [
                'slug' => $post->getSlug()
            ]);
        }

        return $this->render('post/new.html.twig', [
            'postForm' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     *
     * @Route("/posts/{slug}/edit", name="posts_edit")
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $manager)
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong>{$post->getTitle()}</strong> a bien été modifié !"
            );

            return $this->redirectToRoute('posts_show', [
                'slug' => $post->getSlug()
            ]);
        }

        return $this->render('post/edit.html.twig', [
            'postForm' => $form->createView(),
            'post' => $post
        ]);
    }

    /**
     * Affiche un article spécifique de la BDD
     *
     * @Route("/posts/{slug}", name="posts_show")
     *
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }
}