<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * Displays the creation page of a post
     *
     * @Route("/posts/new", name="posts_create")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        if($this->getUser()) {

            $post = new Post();
            $form = $this->createForm(PostType::class, $post);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($post);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "L'article <strong>{$post->getTitle()}</strong> a bien été publié !"
                );

                return $this->redirectToRoute('posts_show', [
                    'slug' => $post->getSlug()
                ]);
            }

            return $this->render('post/new.html.twig', [
                'postForm' => $form->createView()
            ]);
        }else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * Displays the posts list page
     *
     * @Route("/posts/{page<\d+>?1}", name="posts_index")
     * @param PostRepository $repo
     * @param $page
     * @param PaginationService $pagination
     * @return Response
     */
    public function index(PostRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Post::class)
            ->setCurrentPage($page);


        if(empty($pagination->getData())) {
            return $this->redirectToRoute('posts_index');
        }

        return $this->render('post/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Displays the page of a specific article
     *
     * @Route("/posts/{slug}", name="posts_show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * Displays the editing page of a post
     *
     * @Route("/posts/{slug}/edit", name="posts_edit")
     * @param Request $request
     * @param Post $post
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $manager)
    {
        if($this->getUser()) {

            $form = $this->createForm(PostType::class, $post);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($post);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "L'article <strong>{$post->getTitle()}</strong> a bien été modifié !"
                );

                return $this->redirectToRoute('posts_show', [
                    'slug' => $post->getSlug()
                ]);
            }

            return $this->render('post/edit.html.twig', [
                'postForm' => $form->createView(),
                'post' => $post
            ]);
        }else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * Manages deletion of a post
     *
     * @Route("/posts/{slug}/delete", name="posts_delete")
     * @param Post $post
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete(Post $post, EntityManagerInterface $manager)
    {
        if($this->getUser()) {
            $manager->remove($post);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article <strong>{$post->getTitle()}</strong> a bien été supprimé !"
            );

            return $this->redirectToRoute('posts_index');
        }else {

            return $this->redirectToRoute('homepage');
        }
    }
}