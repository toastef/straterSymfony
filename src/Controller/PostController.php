<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/posts', name: 'posts')]
    public function posts(PostRepository $repository): Response
    {
        $posts = $repository->findBy(
            ['isPublished'=>true], // premier array pour les criteres
            ['title'=> 'ASC'], // deuxiemme tab
            10
        );
        return $this->render('post/posts.html.twig', [
            'posts' => $posts,
        ]);
    }
}
