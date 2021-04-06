<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

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
