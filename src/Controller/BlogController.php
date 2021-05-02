<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\DTO\CommentCreate;
use App\Form\ArticleCreateType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
    public function formArticle(Request $request, EntityManagerInterface $manager, AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(ArticleCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ArticleCreate $articleDTO */
            $articleDTO = $form->getData();
            $article = new Article($articleDTO->title, $articleDTO->capon, $articleDTO->content, $lastUsername);
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('showArticles');
        }

        return $this->render('blog/articleCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/showPost/{id}', name: 'showPost')]
    public function showPost($id)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);

        return $this->render('blog/showPost.html.twig', [
            'article' => $article,
        ]);
    }
}
