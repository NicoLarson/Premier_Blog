<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="simple_array")
     */
    private array $roles = ['ROLE_USER'];

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author", cascade={"persist"})
     */
    private Collection $articles;

    /**
     * @ORM\OneToMany(targetEntity=AuthenticateAuthor::class, mappedBy="account", cascade={"persist"})
     */
    private Collection $comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $tokenCreateAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $enabled = false;

    public function __construct(string $email, string $username, string $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->generateToken();
        $this->articles = new ArrayCollection();
        $this->comment = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->username;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt(): void
    {
    }

    public function eraseCredentials(): void
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getComments(): object
    {
        return $this->comments;
    }

    public function setComments(object $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function generateToken(): string
    {
        $this->token = \bin2hex(\random_bytes(12));
        $this->tokenCreateAt = new \DateTime();

        return $this->token;
    }

    public function getTokenCreateAt(): \DateTimeInterface
    {
        return $this->tokenCreateAt;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}
