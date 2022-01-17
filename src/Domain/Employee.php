<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeInterface;

class Employee
{
    private string $email;
    private string $firstname;
    private DateTimeInterface $birthday;

    public function __construct(string $email, string $firstname, DateTimeInterface $birthday)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->birthday = $birthday;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getBirthday(): DateTimeInterface
    {
        return $this->birthday;
    }
}
