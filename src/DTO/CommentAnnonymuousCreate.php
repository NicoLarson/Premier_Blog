<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Comment;
use Symfony\Component\Validator\Constraints as Assert;

class CommentCreate
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
    public $content;
}
