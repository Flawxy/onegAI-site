<?php

namespace App\Controller;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller {

    /**
     * Displays the homepage
     *
     * @Route("/", name="homepage")
     * @param PostRepository $repo
     * @return Response
     */
    public function home(PostRepository $repo)
    {
        $posts = $repo->findAll();
        $botVersion = '';

        foreach ($posts as $post) {
            if (preg_match('/changelog/i', $post->getTitle())) {

                $botVersion = $post->getTitle();
            }
        }
        // On supprime le string "changelog" pour obtenir uniquement la version du bot
        $botVersion = preg_replace('/changelog /i', '', $botVersion);

        // Selects the 3 last posts
        $lastPosts = $repo->findBy(array(), array('createdAt' => 'DESC'), 3);

        return $this->render('home.html.twig', [
            'posts' => $lastPosts,
            'botVersion' => $botVersion
        ]);
    }
}