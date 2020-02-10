<?php

namespace App\Controller;


use App\Repository\PostRepository;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * Displays the homepage
     *
     * @Route("/", name="homepage")
     * @param PostRepository $repo
     * @param ApiService $apiService
     * @return Response
     */
    public function home(PostRepository $repo, ApiService $apiService)
    {
        return $this->render('home.html.twig', [
            'posts' => $repo->findBy([], ['createdAt' => 'DESC'], 3),
            'botVersion' => $apiService->getBotLastVersion()
        ]);
    }
}