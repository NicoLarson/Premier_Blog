<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class InputArticle
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *     min=2,
     *     max=100,
     *     minMessage="Your first title must be at least {{ limit }} characters long",
     *     maxMessage="Your first title cannot be longer than {{ limit }} characters"
     * )
     */
    public $title;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *     min=2,
     *     max=100,
     *     minMessage="Your first capon must be at least {{ limit }} characters long",
     *     maxMessage="Your first capon cannot be longer than {{ limit }} characters"
     * )
     */
    public $capon;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *     min=100,
     *     minMessage="Your first capon must be at least {{ limit }} characters long"
     * )
     */
    public $content;
}
