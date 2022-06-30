<?php


namespace App\Http\Domain\Employee;


use App\Http\Domain\Employee\Contracts\EmployeeInterface;

class Employee implements EmployeeInterface
{
    protected int $age = 0;
    protected int $children = 0;
    protected int $salary = 0;
    protected bool $has_company_car = false;
    protected string $description = '';

    public function setAge(int $value): static
    {
        $this->age = $value;
        return $this;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setChildrenAmount(int $value): static
    {
        $this->children = $value;
        return $this;
    }

    public function getChildrenAmount(): int
    {
        return $this->children;
    }

    public function setSalaryAmount(int $value): static
    {
        $this->salary = $value;
        return $this;
    }

    public function getSalaryAmount(): int
    {
        return $this->salary;
    }

    public function setCompanyCar(bool $value): static
    {
        $this->has_company_car = $value;
        return $this;
    }

    public function getCompanyCar(): bool
    {
        return $this->has_company_car;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
