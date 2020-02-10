<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class ApiController extends AbstractController
{
    /**
     * Displays the last changelog post as JSON
     *
     * @Route("/api/changelog", name="api_changelog")
     * @param ApiService $apiService
     * @return JsonResponse
     */
    public function lastChangelog(ApiService $apiService)
    {
        return JsonResponse::fromJsonString($apiService->getChangelogDataAsJson());
    }
}