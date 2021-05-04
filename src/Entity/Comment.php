<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=AbstractAuthor::class, mappedBy="comment", cascade={"persist"})
     */
    private AbstractAuthor $author;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Article $article;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $creationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    public function __construct(Article $article, AbstractAuthor $author, string $content)
    {
        $this->author = $author;
        $this->author->setComment($this);
        $this->content = $content;
        $this->creationDate = new \DateTimeImmutable();
        $this->article = $article;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): AbstractAuthor
    {
        return $this->author;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
