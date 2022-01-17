<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Employee;
use App\Domain\EmployeeRepository;
use DateTimeInterface;

class InMemoryEmployeeRepository implements EmployeeRepository
{
    /** @var Employee[] */
    private array $employees;

    /**
     * @param Employee[] $employees
     */
    public function __construct(array $employees)
    {
        $this->employees = $employees;
    }

    public function findBornOn(DateTimeInterface $date): array
    {
        return array_filter($this->employees, function (Employee $employee) use ($date) {
            return 0 === $employee->getBirthday()->diff($date)->d;
        });
    }
}
