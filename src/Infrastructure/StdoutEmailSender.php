<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Email;

class StdoutEmailSender implements EmailSender
{
    private const TEMPLATE = 'To: %s, Subject: %s, Message: %s';

    public function send(Email $email): void
    {
        echo sprintf(self::TEMPLATE, $email->getTo(), $email->getSubject(), $email->getMessage());
    }
}
