<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Account;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(entityClass=Account::class, fields={"email"}, message="Cette email est déjà utilisé.")
 * @UniqueEntity(entityClass=Account::class, fields={"username"}, message="Ce nom d'utilisateur est déjà utilisé.")
 */
class AccountCreate
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public $email;

    /**
     * @Assert\NotBlank
     */
    public $username;

    /**
     * @Assert\NotBlank
     */
    public $password;
}
