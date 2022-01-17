<?php

declare(strict_types=1);

namespace App\Application\Greeter;

interface MessageFormatter
{
    public function format(string $message): string;
}
