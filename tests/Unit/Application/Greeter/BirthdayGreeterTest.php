<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Greeter;

use App\Application\Greeter\BirthdayGreeter;
use App\Application\Greeter\BirthdayMessageFormatter;
use App\Domain\Employee;
use App\Infrastructure\InMemoryEmployeeRepository;
use App\Infrastructure\StdoutEmailSender;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class BirthdayGreeterTest extends TestCase
{
    private const SUBJECT = 'fake subject';

    /**
     * @param array<int, array{email: string, firstname: string, birthday: DateTimeInterface}> $employeesData
     * @dataProvider provideEmployeesDataBornOnToday
     */
    public function testShouldGreetBirthdays(array $employeesData): void
    {
        $employees = $this->buildEmployees($employeesData);
        $greeter = new BirthdayGreeter(
            new DateTimeImmutable(),
            new InMemoryEmployeeRepository($employees),
            new BirthdayMessageFormatter(),
            new StdoutEmailSender(),
            self::SUBJECT
        );
        /** @var Employee $employee */
        $employee = array_shift($employees);
        $formattedMessage = sprintf('Happy birthday, dear %s!', $employee->getFirstname());

        self::expectOutputString(
            sprintf(
                'To: %s, Subject: %s, Message: %s',
                $employee->getEmail(),
                self::SUBJECT,
                $formattedMessage,
            )
        );

        $greeter();
    }

    /**
     * @param array<int, array{email: string, firstname: string, birthday: DateTimeInterface}> $employeesData
     * @dataProvider provideEmployeesDataNotBornOnToday
     */
    public function testShouldNotGreetBirthdays(array $employeesData): void
    {
        $employees = $this->buildEmployees($employeesData);

        self::assertFalse(self::hasExpectationOnOutput());

        (new BirthdayGreeter(
            new DateTimeImmutable(),
            new InMemoryEmployeeRepository($employees),
            new BirthdayMessageFormatter(),
            new StdoutEmailSender(),
            self::SUBJECT
        ))();
    }

    /**
     * @param array<int, array{email: string, firstname: string, birthday: DateTimeInterface}> $employeesData
     *
     * @return Employee[]
     */
    private function buildEmployees(array $employeesData): array
    {
        return array_map(function (array $employeeData) {
            return new Employee($employeeData['email'], $employeeData['firstname'], $employeeData['birthday']);
        }, $employeesData);
    }

    /**
     * @return iterable<array<int, array<int, array{email: string, firstname: string, birthday: DateTimeInterface}>>>
     */
    public function provideEmployeesDataBornOnToday(): iterable
    {
        yield [
            [
                [
                    'email' => 'test1@test.com',
                    'firstname' => 'User 1',
                    'birthday' => new DateTimeImmutable(),
                ],
            ],
        ];
    }

    /**
     * @return iterable<array<int, array<int, array{email: string, firstname: string, birthday: DateTimeInterface}>>>
     */
    public function provideEmployeesDataNotBornOnToday(): iterable
    {
        yield [
            [
                [
                    'email' => 'test1@test.com',
                    'firstname' => 'User 1',
                    'birthday' => new DateTimeImmutable('+2 day'),
                ],
            ],
        ];
    }
}
