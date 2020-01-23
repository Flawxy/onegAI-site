<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $posts = $repo->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts
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