<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use ReallySimpleJWT\Token;
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
     * @param Request $request
     * @param PostRepository $repo
     * @return JsonResponse|Response
     */
    public function lastChangelog(Request $request, PostRepository $repo)
    {

        //Remplacer 'cookie' par la gestion du JasonWebToken (ne pas écrire en DUR, utiliser .env et les var Heroku
        //if($request->headers->has('cookie')) {

            $response = new JsonResponse();

            $posts = $repo->findBy(array(), array('id' => 'DESC'));

            foreach ($posts as $post) {
                if(preg_match('/changelog/i', $post->getTitle())) {
                    $response->setContent(json_encode([
                        'id' => $post->getId(),
                        'title' => $post->getTitle(),
                        'content' => $post->getContent(),
                        'slug' => $post->getSlug(),
                        'createdAt' => $post->getCreatedAt(),
                        'image' => $post->getImage(),
                        'introduction' => $post->getIntroduction()
                    ]));

                    return $response;
                }
            }
            return new Response("Une erreur est survenue durant la communication avec l'API...");
        /*}else {
            return new Response("Vous n'avez pas l'autorisation d'accéder à ces informations");
        }*/
    }
}
