<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Email;

interface EmailSender
{
    public function send(Email $email): void;
}
