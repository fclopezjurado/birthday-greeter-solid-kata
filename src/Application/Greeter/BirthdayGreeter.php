<?php

declare(strict_types=1);

namespace App\Application\Greeter;

use App\Domain\Email;
use App\Domain\EmployeeRepository;
use App\Infrastructure\EmailSender;
use DateTimeInterface;

class BirthdayGreeter
{
    private DateTimeInterface $date;
    private EmployeeRepository $repository;
    private MessageFormatter $formatter;
    private EmailSender $sender;
    private string $subject;

    public function __construct(
        DateTimeInterface $date,
        EmployeeRepository $repository,
        MessageFormatter $formatter,
        EmailSender $sender,
        string $subject
    ) {
        $this->date = $date;
        $this->repository = $repository;
        $this->formatter = $formatter;
        $this->sender = $sender;
        $this->subject = $subject;
    }

    public function __invoke(): void
    {
        $employees = $this->repository->findBornOn($this->date);

        foreach ($employees as $employee) {
            $message = $this->formatter->format($employee->getFirstname());
            $email = new Email($employee->getEmail(), $this->subject, $message);

            $this->sender->send($email);
        }
    }
}
