<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Greeter;

use App\Application\Greeter\BirthdayMessageFormatter;
use PHPUnit\Framework\TestCase;

class BirthdayMessageFormatterTest extends TestCase
{
    /**
     * @dataProvider provideMessages
     */
    public function testShouldFormat(string $message): void
    {
        $formattedMessage = (new BirthdayMessageFormatter())->format($message);

        self::assertSame(sprintf('Happy birthday, dear %s!', $message), $formattedMessage);
    }

    /**
     * @return iterable<array<int, string>>
     */
    public function provideMessages(): iterable
    {
        yield ['fake user 1'];
        yield ['fake user 2'];
        yield ['fake user 3'];
    }
}
