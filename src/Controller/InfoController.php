<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfoController extends AbstractController
{
    /**
     * Displays the info page (the OnegAI's project)
     *
     * @Route("/info", name="info_index")
     * @return Response
     */
    public function index()
    {
        return $this->render('info/index.html.twig');
    }
}
