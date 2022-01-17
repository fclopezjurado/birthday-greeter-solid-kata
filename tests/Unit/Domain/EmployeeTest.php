<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\Employee;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @group Domain
 */
class EmployeeTest extends TestCase
{
    /**
     * @dataProvider provideEmployeeData
     *
     * @param array{email: string, firstname: string, birthday: DateTimeInterface} $data
     */
    public function testShouldCreateEmployee(array $data): void
    {
        $employee = new Employee($data['email'], $data['firstname'], $data['birthday']);

        self::assertSame($data['email'], $employee->getEmail());
        self::assertSame($data['firstname'], $employee->getFirstname());
        self::assertSame($data['birthday'], $employee->getBirthday());
    }

    /**
     * @dataProvider provideWrongEmployeeData
     *
     * @param array{email: string, firstname: string, birthday: DateTimeInterface} $data
     */
    public function testShouldNotCreateEmployee(array $data): void
    {
        self::expectError();

        $employee = new Employee($data['email'], $data['firstname'], $data['birthday']);

        self::assertSame($data['email'], $employee->getEmail());
    }

    /**
     * @return iterable<array<int, array<string, DateTimeInterface|string>>>
     */
    public function provideEmployeeData(): iterable
    {
        yield [
            [
                'email' => 'test@test.com',
                'firstname' => 'User 1',
                'birthday' => new DateTimeImmutable(),
            ],
        ];
    }

    /**
     * @return iterable<array<int, array<string, DateTimeInterface|string|int>>>
     */
    public function provideWrongEmployeeData(): iterable
    {
        yield [
            [
                'email' => 1,
                'firstname' => 'User 1',
                'birthday' => new DateTimeImmutable(),
            ],
        ];
        yield [
            [
                'email' => 'test@test.com',
                'firstname' => 2,
                'birthday' => new DateTimeImmutable(),
            ],
        ];
        yield [
            [
                'email' => 'test@test.com',
                'firstname' => 'User 1',
                'birthday' => 'fake-date',
            ],
        ];
    }
}
