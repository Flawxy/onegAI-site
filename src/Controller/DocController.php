<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Form\DocumentationType;
use App\Repository\CategoryRepository;
use App\Repository\DocumentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends AbstractController
{
    /**
     * @Route("/doc", name="doc_index")
     *
     */
    public function index(DocumentationRepository $repo)
    {
            $entries = $repo->findBy(array(), array('category' => 'ASC'));

        return $this->render('doc/index.html.twig', [
            'entries' => $entries
        ]);
    }

    /**
     * Permet de créer une entrée dans la documentation
     *
     * @Route("/doc/new", name="doc_create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $doc = new Documentation();

        $form = $this->createForm(DocumentationType::class, $doc);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($doc);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'entrée <strong>{$doc->getCommand()}</strong> a bien été ajoutée à la documentation !"
            );

            return $this->redirectToRoute('doc_index', [
                '_fragment' => 'entry'.$doc->getId()
            ]);
        }

        return $this->render('doc/new.html.twig', [
            'docForm' => $form->createView()
        ]);
    }
}
