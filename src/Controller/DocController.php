<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\DocumentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends AbstractController
{
    /**
     * @Route("/doc", name="doc_index")
     */
    public function index(DocumentationRepository $repo)
    {
            $entries = $repo->findAll();

        return $this->render('doc/index.html.twig', [
            'entries' => $entries
        ]);
    }
}
