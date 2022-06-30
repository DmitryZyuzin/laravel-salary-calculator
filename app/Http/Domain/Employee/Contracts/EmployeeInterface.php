<?php


namespace App\Http\Domain\Employee\Contracts;

interface EmployeeInterface
{

    public function setDescription(string $description): static;

    public function getDescription(): string;

    public function setAge(int $value): static;

    public function getAge(): int;

    public function setChildrenAmount(int $value): static;

    public function getChildrenAmount(): int;

    public function setSalaryAmount(int $value): static;

    public function getSalaryAmount(): int;

    public function setCompanyCar(bool $value): static;

    public function getCompanyCar(): bool;

}
