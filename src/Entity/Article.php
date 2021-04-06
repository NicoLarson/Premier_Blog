<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $capon;

    /**
     * @ORM\Column(type="string")
     */
    private string $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private object $creationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?object $lastUpdateDate;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private array $comments = [];

    public function __construct(string $title, string $capon, string $content)
    {
        $this->title = $title;
        $this->capon = $capon;
        $this->content = $content;
        $this->creationDate = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCapon(): ?string
    {
        return $this->capon;
    }

    public function setCapon(string $capon): self
    {
        $this->capon = $capon;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreationDate(): ?DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getLastUpdateDate(): ?DateTimeInterface
    {
        return $this->lastUpdateDate;
    }

    public function setLastUpdateDate(?DateTimeInterface $lastUpdateDate): self
    {
        $this->lastUpdateDate = $lastUpdateDate;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getComments(): ?array
    {
        return $this->comments;
    }

    public function setComments(?array $comments): self
    {
        $this->comments = $comments;

        return $this;
    }
}
