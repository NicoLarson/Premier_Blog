<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AuthenticateAuthor extends AbstractAuthor
{
    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function getUsername(): string
    {
        return $this->account->getUsername();
    }

    public function getEmail(): string
    {
        return $this->account->getEmail();
    }
}
