<?php

namespace App\Controller;

use App\Entity\Post; // va utiliser l'entité POst pour aller chercher les différents éléments demandé
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/posts', name: 'posts')]
    public function posts(PostRepository $repository): Response
    {
        $posts = $repository->findBy(
            ['isPublished'=>true], // premier array pour les critères
            ['title'=> 'ASC'] // deuxiemme tab
        );
        return $this->render('post/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @param Post $post
     * @return Response
     */
    #[Route('post/{id}', name:'post')]
    public function post(Post $post): Response
    {
        return $this->render('post/detail.html.twig', [
            'post' => $post,
    ]);

    }

    #[Route('post/editpost/{id}', name: 'editpost')]

    public function editPost(Post $post, EntityManagerInterface $manager,Request $request): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isSubmitted()) {
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('posts');
        }
        return $this->render('post/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
