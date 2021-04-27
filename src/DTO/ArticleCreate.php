<?php

declare(strict_types=1);

namespace App\DTO;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class ArticleCreate
{
    /**
     * @Assert\NotBlank
     */
    public $title;

    /**
     * @Assert\NotBlank
     */
    public $capon;

    /**
     * @Assert\NotBlank
     */
    public $content;
}
