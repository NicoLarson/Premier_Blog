<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CommentMembersCreate
{
    /**
     * @Assert\NotBlank
     */
    public $content;
}
