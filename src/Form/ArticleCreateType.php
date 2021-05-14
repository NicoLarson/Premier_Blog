<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\InputArticle;
use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleCreateType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('capon')
            ->add('content', TextareaType::class)
            ->add('authorId', ChoiceType::class, [
                'choices' => $this->buildChoiceAuthor(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InputArticle::class,
        ]);
    }

    private function buildChoiceAuthor(): array
    {
        $members = $this->entityManager->getRepository(Account::class)->findAll();
        $result = [];

        foreach ($members as $member) {
            $result[$member->getUsername()] = $member->getId();
        }

        return $result;
    }
}
