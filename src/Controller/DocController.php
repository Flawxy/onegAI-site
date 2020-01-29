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
     * Permet d'afficher le formulaire d'édition
     *
     * @Route("/doc/{id}/edit", name="doc_edit")
     *
     * @param Request $request
     * @param Documentation $documentation
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
     * Permet de supprimer un article
     *
     *@Route("/doc/{id}/delete", name="doc_delete")
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
