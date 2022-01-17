<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeInterface;

interface EmployeeRepository
{
    /**
     * @return Employee[]
     */
    public function findBornOn(DateTimeInterface $date): array;
}
