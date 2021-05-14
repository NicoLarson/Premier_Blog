<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"anonymous": "AnonymousAuthor", "authenticate": "AuthenticateAuthor"})
 */
abstract class AbstractAuthor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=Comment::class, inversedBy="author")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Comment $comment;

    public function __toString()
    {
        return '*'.$this->getUsername().'*';
    }

    public function setComment(Comment $comment): void
    {
        $this->comment = $comment;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

    abstract public function getUsername(): string;

    abstract public function getEmail(): string;
}
