<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    #[Assert\NotBlank]
    #[Assert\length(min:3)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\length(min:3,max:300)]
    public string $message;
    
    #[Assert\NotBlank]
    #[Assert\length(min:3,max:300)]
    public string $service;
}