<?php


namespace App\Http\Domain\Support\Contracts;


use App\Http\Domain\Employee\Contracts\EmployeeInterface;

abstract class SalaryCalculatorInterface
{

    protected function getPersonalTaxSum(int $salary_sum, int $tax_percentage): int
    {
        return intval($salary_sum * ($tax_percentage / 100));
    }

    abstract function calculate(TaxesInterface $taxes, EmployeeInterface $employee);


}
