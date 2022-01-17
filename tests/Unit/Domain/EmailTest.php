<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\Email;
use PHPUnit\Framework\TestCase;

/**
 * @group Domain
 */
class EmailTest extends TestCase
{
    /**
     * @dataProvider provideEmailData
     *
     * @param array{to: string, subject: string, message: string} $data
     */
    public function testShouldCreateEmail(array $data): void
    {
        $email = new Email($data['to'], $data['subject'], $data['message']);

        self::assertSame($data['to'], $email->getTo());
        self::assertSame($data['subject'], $email->getSubject());
        self::assertSame($data['message'], $email->getMessage());
    }

    /**
     * @dataProvider provideWrongEmailData
     *
     * @param array{to: string, subject: string, message: string} $data
     */
    public function testShouldNotCreateEmail(array $data): void
    {
        self::expectError();

        $email = new Email($data['to'], $data['subject'], $data['message']);

        self::assertSame($data['to'], $email->getTo());
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

    /**
     * @return iterable<array<int, array<string, string|int>>>
     */
    public function provideWrongEmailData(): iterable
    {
        yield [
            [
                'to' => 2,
                'subject' => 'fake-subject',
                'message' => 'fake-message',
            ],
        ];
        yield [
            [
                'to' => 'test@test.com',
                'subject' => 26,
                'message' => 'fake-message',
            ],
        ];
        yield [
            [
                'to' => 'test@test.com',
                'subject' => 'fake-subject',
                'message' => 78,
            ],
        ];
    }
}
