<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\AnonymousAuthor;
use App\Form\ArticleCreateType;
use App\Form\CommentMembersType;
use App\Entity\AuthenticateAuthor;
use App\Form\CommentAnonymousType;
use App\DTO\CommentAnonymousCreate;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
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
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }

        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(ArticleCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ArticleCreate $articleDTO */
            $articleDTO = $form->getData();
            $article = new Article($articleDTO->title, $articleDTO->capon, $articleDTO->content, $this->getUser());
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('showArticles');
        }

        return $this->render('blog/articleCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show-post/{id}', name: 'showPost')]
    public function showPost($id, Request $request, EntityManagerInterface $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);

        if (null !== $this->getUser()) {
            $form = $this->createForm(CommentMembersType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var CommentMembersCreate $commentDTO */
                $commentDTO = $form->getData();
                $author = new AuthenticateAuthor($this->getUser());
                $comment = new Comment($article, $author, $commentDTO->content);
                $manager->persist($comment);
                $manager->flush();

                return $this->redirectToRoute('showPost', ['id' => $id]);
            }
            return $this->render('blog/showPostMembers.html.twig', [
                'article' => $article,
                'form' => $form->createView(),
            ]);
        } else {
            $form = $this->createForm(CommentAnonymousType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var CommentAnonymousCreate $commentDTO */
                $commentDTO = $form->getData();
                $author = new AnonymousAuthor($commentDTO->username, $commentDTO->email);
                $comment = new Comment($article, $author, $commentDTO->content);
                $manager->persist($comment);
                $manager->flush();

                return $this->redirectToRoute('showPost', ['id' => $id]);
            }
            return $this->render('blog/showPostAnonymous.html.twig', [
                'article' => $article,
                'form' => $form->createView(),
            ]);
        }
    }
}
