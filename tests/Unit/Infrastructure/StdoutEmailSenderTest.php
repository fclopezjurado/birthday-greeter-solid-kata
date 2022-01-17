<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure;

use App\Domain\Email;
use App\Infrastructure\StdoutEmailSender;
use PHPUnit\Framework\TestCase;

class StdoutEmailSenderTest extends TestCase
{
    /**
     * @dataProvider provideEmailData
     *
     * @param array{to: string, subject: string, message: string} $data
     */
    public function testShouldSend(array $data): void
    {
        $email = new Email($data['to'], $data['subject'], $data['message']);

        self::expectOutputString(
            sprintf(
                'To: %s, Subject: %s, Message: %s',
                $email->getTo(),
                $email->getSubject(),
                $email->getMessage()
            )
        );

        (new StdoutEmailSender())->send($email);
    }

    /**
     * @return iterable<array<int, array<string, string>>>
     */
    public function provideEmailData(): iterable
    {
        yield [
            [
                'to' => 'test@test.com',
                'subject' => 'fake-subject',
                'message' => 'fake-message',
            ],
        ];
    }
}
