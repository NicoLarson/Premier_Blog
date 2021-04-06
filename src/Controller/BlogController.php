<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleCreateType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/', name: 'blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/home', name: 'home')]
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    #[Route('/showArticles', name: 'showArticles')]
    public function showArticles(ArticleRepository $articleRepository)
    {
        return $this->render('blog/articlesList.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/createArticle', name: 'createArticle')]
    public function formArticle(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ArticleCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ArticleCreate $articleDTO */
            $articleDTO = $form->getData();
            $article = new Article($articleDTO->title, $articleDTO->capon, $articleDTO->content);
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('showArticles');
        }

        return $this->render('blog/articleCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
