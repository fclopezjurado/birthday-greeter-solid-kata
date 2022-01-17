<?php

declare(strict_types=1);

namespace App\Application\Greeter;

class BirthdayMessageFormatter implements MessageFormatter
{
    private const TEMPLATE = 'Happy birthday, dear %s!';

    public function format(string $message): string
    {
        return sprintf(self::TEMPLATE, $message);
    }
}
