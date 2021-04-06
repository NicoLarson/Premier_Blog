<?php

namespace App\Entity;

use App\Repository\AccountsRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AccountsRepository::class)
 * @UniqueEntity(fields={"email"}, message="Cette email est déjà utilisé.")
 * @UniqueEntity(fields={"username"}, message="Ce nom d'utilisateur est déjà utilisé.")
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
     * @Assert\EqualTo(propertyPath="confirmPassword", message="Les mots de passe entrés ne correspondent pas")
     */
    private string $password;


    /**
     * @ORM\Column(type="simple_array")
     */
    private array $roles = ['ROLE_USER'];

    /**
     * @ORM\Column(type="object")
     */
    private ?object $comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $token = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $tokenCreateAt;

    /**
     * @ORM\Column(type="bool")
     */
    private bool $enabled;





    public function __construct(string $email, string $username, string $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
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
        $this->type = $comments;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->type = $token;

        return $this;
    }

    public function getTokenCreateAt(): string
    {
        return $this->tokenCreateAt;
    }

    public function setTokenCreateAt(string $tokenCreateAt): self
    {
        $this->type = $tokenCreateAt;

        return $this;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->type = $enabled;

        return $this;
    }
}
