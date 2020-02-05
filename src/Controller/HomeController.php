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
        // Selects the 3 last posts
        $lastPosts = $repo->findBy(array(), array('createdAt' => 'DESC'), 3);

        return $this->render('home.html.twig', [
            'posts' => $lastPosts
        ]);
    }
}