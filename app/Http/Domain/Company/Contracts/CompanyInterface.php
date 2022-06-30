<?php


namespace App\Http\Domain\Company\Contracts;


use App\Http\Domain\Employee\Contracts\EmployeeInterface;
use App\Http\Domain\Support\Contracts\SalaryCalculatorInterface;
use App\Http\Domain\Support\Contracts\TaxesInterface;

interface CompanyInterface
{

    public function setEmployee(EmployeeInterface $employee): static;

    public function setTax(TaxesInterface $taxes): static;

    public function setCalculator(SalaryCalculatorInterface $salaryCalculator): static;

    public function getSalaryAmount(): int;

}
