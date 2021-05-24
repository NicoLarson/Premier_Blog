<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\AbstractAuthor;
use App\Entity\Account;
use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/administration', name: 'adminPage')]
    public function adminPage(EntityManagerInterface $manager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $articles = $entityManager->getRepository(Article::class)->findAll();
        $members = $entityManager->getRepository(Account::class)->findAll();
        $comments = $entityManager->getRepository(Comment::class)->findAll();
        $anonymousCommentAuthor = $entityManager->getRepository(AbstractAuthor::class)->findAll();

        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Veuillez vous connecter en tant qu\'administrateur du blog');

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'blog/adminPage.html.twig', [
            'articles' => $articles,
            'members' => $members,
            'comments' => $comments,
            'anonymousCommentAuthor' => $anonymousCommentAuthor,
            ]
        );
    }

    #[Route('/inscription-validation/{id}', name: 'inscriptionValidation')]
    public function inscriptionValidation($id, EntityManagerInterface $manager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $member = $entityManager->getRepository(Account::class)->find($id);

        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Veuillez vous connecter en tant qu\'administrateur du blog');

            return $this->redirectToRoute('app_login');
        }
        $member->enable();
        $manager->flush();

        return $this->redirectToRoute('adminPage');
    }

    #[Route('/delete-account/{id}', name: 'deleteAccount')]
    public function deleteAccount($id, EntityManagerInterface $manager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $member = $entityManager->getRepository(Account::class)->find($id);

        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Veuillez vous connecter en tant qu\'administrateur du blog');

            return $this->redirectToRoute('app_login');
        }
        $manager->remove($member);
        $manager->flush();

        return $this->redirectToRoute('adminPage');
    }

    #[Route('/add-account-role/{id}', name: 'addAdminRole')]
    public function changeAccountRole($id, EntityManagerInterface $manager)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Veuillez vous connecter en tant qu\'administrateur du blog');

            return $this->redirectToRoute('app_login');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $member = $entityManager->getRepository(Account::class)->find($id);
        $member->addAdminRoles();
        $manager->persist($member);
        $manager->flush();

        return $this->redirectToRoute('adminPage');
    }

    #[Route('/remove-account-role/{id}', name: 'removeAdminRole')]
    public function removeAccountRole($id, EntityManagerInterface $manager)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Veuillez vous connecter en tant qu\'administrateur du blog');

            return $this->redirectToRoute('app_login');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $member = $entityManager->getRepository(Account::class)->find($id);
        $member->removeAdminRole();
        $manager->persist($member);
        $manager->flush();

        return $this->redirectToRoute('adminPage');
    }

    #[Route('/validation-comment/{id}', name: 'validationComment')]
    public function validationComment($id, EntityManagerInterface $manager)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Veuillez vous connecter en tant qu\'administrateur du blog');

            return $this->redirectToRoute('app_login');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        $comment->enable();
        $manager->flush();

        return $this->redirectToRoute('adminPage');
    }

    #[Route('/delete-comment//{id}', name: 'deleteComment')]
    public function deleteComment($id, EntityManagerInterface $manager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Veuillez vous connecter en tant qu\'administrateur du blog');

            return $this->redirectToRoute('app_login');
        }
        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute('adminPage');
    }
}
