<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CommentAnonymousCreate;
use App\DTO\InputArticle;
use App\Entity\Account;
use App\Entity\AnonymousAuthor;
use App\Entity\Article;
use App\Entity\AuthenticateAuthor;
use App\Entity\Comment;
use App\Form\ArticleCreateType;
use App\Form\CommentAnonymousType;
use App\Form\CommentMembersType;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
    public function home(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = (new Email())
                ->from($formData->email)
                ->to('contact@nicolasyang.fr')
                ->subject('Message du blog!')
                ->text($formData->message)
                ->html($this->renderView('mails/contactMe.html.twig', [
                    'lastName' => $formData->lastName,
                    'firstName' => $formData->firstName,
                    'email' => $formData->email,
                    'message' => $formData->message,
                ]));

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('home');
        }

        return $this->render('blog/home.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/showArticles', name: 'showArticles')]
    public function showArticles(ArticleRepository $articleRepository)
    {
        return $this->render('blog/articlesList.html.twig', [
            'articles' => $articleRepository->findBy([], ['lastUpdateDate' => 'DESC']),
        ]);
    }

    #[Route('/create-article', name: 'createArticle')]
    public function formArticle(Request $request, EntityManagerInterface $manager): Response
    {
        $currentUser = $this->getUser();

        if (!$currentUser instanceof Account || !$currentUser->getEnabled()) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(ArticleCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var InputArticle $articleDTO */
            $articleDTO = $form->getData();
            $article = new Article($articleDTO->title, $articleDTO->capon, $articleDTO->content, $this->getUser());
            $manager->persist($article);
            $manager->flush();

            $this->addFlash('success', 'Votre article a été ajouté.');

            return $this->redirectToRoute('showArticles');
        }

        return $this->render('blog/articleCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteArticle/{id}', name: 'deleteArticle')]
    public function deleteArticle($id, EntityManagerInterface $manager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        $currentUser = $this->getUser();

        if ('ADMIN' !== $currentUser->getRoles()[0]) {
            if (!$currentUser instanceof Account || $article->getAuthor()->getId() !== $currentUser->getId()) {
                throw $this->createAccessDeniedException();
            }
        }

        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute('showArticles');
    }

    #[Route('/updateArticle/{id}', name: 'updateArticle')]
    public function updateArticle($id, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ArticleCreateType::class);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        $members = $entityManager->getRepository(Account::class)->findAll();
        $currentUser = $this->getUser();

        if (!$currentUser instanceof Account || ($article->getAuthor()->getId() !== $currentUser->getId() && $this->isGranted(['ROLE_ADMIN']))) {
            throw $this->createAccessDeniedException();
        }

        if (!$article) {
            throw $this->createNotFoundException('No article found for id '.$id);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var InputArticle $articleDTO */
            $articleDTO = $form->getData();
            $author = $entityManager->getRepository(Account::class)->find($articleDTO->authorId);
            $article->setTitle($articleDTO->title)
                ->setCapon($articleDTO->capon)
                ->setContent($articleDTO->content)
                ->setAuthor($author)
                ->setLastUpdateDateNow();
            $manager->flush();

            return $this->redirectToRoute('showPost', ['id' => $id]);
        }

        return $this->render('blog/updateArticle.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'members' => $members,
        ]);
    }

    #[Route('/show-post/{id}', name: 'showPost')]
    public function showPost($id, Request $request, EntityManagerInterface $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        $currentUser = $this->getUser();
        $currentUserIsAuthor = false;

        if (null !== $this->getUser()) {
            if ($article->getAuthor()->getId() === $currentUser->getId()) {
                $currentUserIsAuthor = true;
            }
            $form = $this->createForm(CommentMembersType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var CommentMembersCreate $commentDTO */
                $commentDTO = $form->getData();
                $author = new AuthenticateAuthor($this->getUser());
                $comment = new Comment($article, $author, $commentDTO->content);
                $manager->persist($comment);
                $manager->flush();
                $this->addFlash('warning', 'Votre commentaire est en attente pour validation.');

                return $this->redirectToRoute('showPost', ['id' => $id]);
            }

            return $this->render('blog/showPostMembers.html.twig', [
                'article' => $article,
                'form' => $form->createView(),
                'id' => $id,
                'currentUserIsAuthor' => $currentUserIsAuthor,
            ]);
        }
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
