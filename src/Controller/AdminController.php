<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\CategoryType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @param PostRepository $repository
     * @return Response
     */
    #[Route('/admin', name: 'admin')]
    public function post(PostRepository $repository): Response
    {
        $posts = $repository->findBy(
            [],
            ['createdAt' => 'DESC']

        );

        return $this->render('admin/admin.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @param Post $post
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/amin/delete/{id}', name: 'delete')]
    public function delete(Post $post, EntityManagerInterface $manager): Response
    {
        $manager->remove($post);
        $manager->flush(); // script pour le delete pris en compte par $manager
        return $this->redirectToRoute('admin'); // vient de l'abstractcontroller pour rediriger vers l'admin
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/admin/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $post = new Post(); // instanciation de la classe Post
        $form = $this->createForm(PostType::class, $post);  // creation du formulaire
        $form->handleRequest($request);  // récupéeration des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {  // vérification si les données sont valide
            $post->setCreatedAt(new \DateTimeImmutable()) // on va setter les éléments qui ne figure pas dans le formulaire en chainage
                ->setImage('default.png');
            $manager->persist($post); // on persiste ( comme un prepare en sql)
            $manager->flush(); // on execute la request
            return $this->redirectToRoute('admin'); // on repasse par le controller
        }
        return $this->renderForm('admin/new.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @param Category $category
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/editcat', name: 'editcat')]
    public function editCat(EntityManagerInterface $manager, Request $request) : Response
    {
        $category = new Category();
        $formcat = $this->createForm(CategoryType::class, $category); // création du form de modification de l'article
        $formcat->handleRequest($request); // récupération des donnée du form
        if($formcat->isSubmitted() && $formcat->isValid()) {
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->renderForm('/admin/editcat.html.twig', [
            'form' => $formcat
        ]);
    }



}

