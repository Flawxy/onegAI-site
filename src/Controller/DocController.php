<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Form\DocumentationType;
use App\Repository\CategoryRepository;
use App\Repository\DocumentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends AbstractController
{
    /**
     * Displays the creation page of a new documentation entry
     *
     * @Route("/doc/new", name="doc_create")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        if($this->getUser()) {

            $doc = new Documentation();

            $form = $this->createForm(DocumentationType::class, $doc);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($doc);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "L'entrée <strong>{$doc->getCommand()}</strong> a bien été ajoutée à la documentation !"
                );

                return $this->redirectToRoute('doc_index', [
                    '_fragment' => 'entry' . $doc->getId()
                ]);
            }

            return $this->render('doc/new.html.twig', [
                'docForm' => $form->createView()
            ]);
        }else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * Displays the main page of the documentation
     *
     * @Route("/doc", name="doc_index")
     * @param DocumentationRepository $repo
     * @return Response
     */
    public function index(DocumentationRepository $repo)
    {
            $entries = $repo->findBy(array(), array('category' => 'ASC'));

        return $this->render('doc/index.html.twig', [
            'entries' => $entries
        ]);
    }

    /**
     * Displays the editing page of a documentation entry
     *
     * @Route("/doc/{id}/edit", name="doc_edit")
     *
     * @param Request $request
     * @param Documentation $doc
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Documentation $doc, EntityManagerInterface $manager)
    {
        if($this->getUser()) {

            $form = $this->createForm(DocumentationType::class, $doc);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($doc);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "L'entrée <strong>{$doc->getCommand()}</strong> a bien été modifiée !"
                );

                return $this->redirectToRoute('doc_index', [
                    '_fragment' => 'entry' . $doc->getId()
                ]);
            }

            return $this->render('doc/edit.html.twig', [
                'docForm' => $form->createView(),
                'entry' => $doc
            ]);
        }else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * Manages deletion of a documentation entry
     *
     * @Route("/doc/{id}/delete", name="doc_delete")
     * @param Documentation $doc
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete(Documentation $doc, EntityManagerInterface $manager)
    {
        if($this->getUser()) {
            $manager->remove($doc);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'entrée <strong>{$doc->getCommand()}</strong> a bien été supprimée !"
            );

            return $this->redirectToRoute('doc_index');
        }else {

            return $this->redirectToRoute('homepage');
        }
    }
}
