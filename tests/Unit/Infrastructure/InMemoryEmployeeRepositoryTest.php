<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure;

use App\Domain\Employee;
use App\Infrastructure\InMemoryEmployeeRepository;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class InMemoryEmployeeRepositoryTest extends TestCase
{
    /**
     * @param array<int, array{email: string, firstname: string, birthday: DateTimeInterface}> $employeesData
     * @dataProvider provideEmployeesDataBornOnToday
     */
    public function testShouldFindEmployeesBornOnToday(array $employeesData): void
    {
        $employees = $this->buildEmployees($employeesData);
        $employeeRepository = new InMemoryEmployeeRepository($employees);
        $expectedNumberOfEmployees = count($employeesData);
        $numberOfEmployeesBornOnToday = $employeeRepository->findBornOn(new DateTimeImmutable());

        self::assertCount($expectedNumberOfEmployees, $numberOfEmployeesBornOnToday);
    }

    /**
     * @param array<int, array{email: string, firstname: string, birthday: DateTimeInterface}> $employeesData
     * @dataProvider provideEmployeesDataNotBornOnToday
     */
    public function testShouldNotFindEmployeesBornOnToday(array $employeesData): void
    {
        $employees = $this->buildEmployees($employeesData);
        $employeeRepository = new InMemoryEmployeeRepository($employees);
        $numberOfEmployeesBornOnToday = $employeeRepository->findBornOn(new DateTimeImmutable());

        self::assertCount(0, $numberOfEmployeesBornOnToday);
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
                [
                    'email' => 'test2@test.com',
                    'firstname' => 'User 2',
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
                [
                    'email' => 'test2@test.com',
                    'firstname' => 'User 2',
                    'birthday' => new DateTimeImmutable('+2 day'),
                ],
            ],
        ];
    }
}
