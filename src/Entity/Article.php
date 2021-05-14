<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="articles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Account $author;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $creationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $lastUpdateDate;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article", cascade={"persist", "remove"})
     * @ORM\OrderBy({"creationDate": "DESC"})
     */
    private Collection $comments;

    public function __construct(string $title, string $capon, string $content, Account $author)
    {
        $this->title = $title;
        $this->capon = $capon;
        $this->content = $content;
        $this->creationDate = new DateTimeImmutable();
        $this->author = $author;
        $this->comments = new ArrayCollection();
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

    public function getAuthor(): Account
    {
        return $this->author;
    }

    public function setAuthor(Account $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreationDate(): ?DateTimeInterface
    {
        return $this->creationDate;
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

    public function getComments(): iterable
    {
        return $this->comments;
    }

    public function setComments(iterable $comments): self
    {
        $this->comments = new ArrayCollection($comments instanceof \Traversable ? \iterator_to_array($comments) : $comments);

        return $this;
    }
}
