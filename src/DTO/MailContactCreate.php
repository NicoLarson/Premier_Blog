<?php

declare(strict_types=1);

namespace App\DTO;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class MailContactCreate
{
    /**
     * @Assert\NotBlank
     */
    public $lastName;

    /**
     * @Assert\NotBlank
     */
    public $firstName;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    public $email;

    /**
     * @Assert\NotBlank
     */
    public $message;
}
