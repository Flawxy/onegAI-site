<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ApiController extends AbstractController
{
    /**
     * Displays the last changelog post as JSON
     *
     * @Route("/api/changelog", name="api_changelog")
     * @param ApiService $apiService
     * @return JsonResponse|Response
     */
    public function lastChangelog(ApiService $apiService)
    {
        return JsonResponse::fromJsonString($apiService->getChangelogDataAsJson());
    }
}