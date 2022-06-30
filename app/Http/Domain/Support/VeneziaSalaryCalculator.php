<?php


namespace App\Http\Domain\Support;


use App\Http\Domain\Employee\Contracts\EmployeeInterface;
use App\Http\Domain\Support\Contracts\SalaryCalculatorInterface;
use App\Http\Domain\Support\Contracts\TaxesInterface;

class VeneziaSalaryCalculator extends SalaryCalculatorInterface
{
    protected int $age_to_bonus;
    protected float $age_bonus_multiplier;

    protected int $children_amount_to_reduce_tax;
    protected int $children_tax_reduce_percentage;

    protected int $company_car_discount;

    public function __construct()
    {
        $this->age_to_bonus =  config('venezia_stone.personal_taxes.age_to_bonus');
        $this->age_bonus_multiplier = config('venezia_stone.personal_taxes.age_bonus_multiplier');

        $this->children_amount_to_reduce_tax = config('venezia_stone.personal_taxes.children_amount_to_reduce_tax');
        $this->children_tax_reduce_percentage = config('venezia_stone.personal_taxes.children_tax_reduce_percentage');

        $this->company_car_discount = config('venezia_stone.personal_taxes.company_car_discount');

    }

    public function calculate(TaxesInterface $taxes, EmployeeInterface $employee)
    {
        if ($employee->getAge() >= $this->age_to_bonus) {
            $employee->setSalaryAmount($employee->getSalaryAmount() * $this->age_bonus_multiplier);
        }

        if ($employee->getChildrenAmount() >= $this->children_amount_to_reduce_tax) {
            $taxes->setTaxPercentage($taxes->getTaxPercentage() - $this->children_tax_reduce_percentage);
        }

        if ($employee->getCompanyCar() === true) {
            $employee->setSalaryAmount($employee->getSalaryAmount() - $this->company_car_discount);
        }

        return $employee->getSalaryAmount() - $this->getPersonalTaxSum($employee->getSalaryAmount(), $taxes->getTaxPercentage());
    }

}
