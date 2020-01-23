<?php

namespace App\Controller;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function home(PostRepository $repo)
    {
        $lastPosts = $repo->findBy(array(), array('createdAt' => 'DESC'), 3);

        return $this->render('home.html.twig', [
            'lastPosts' => $lastPosts
        ]);
    }
}