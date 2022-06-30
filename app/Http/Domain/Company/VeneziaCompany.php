<?php


namespace App\Http\Domain\Company;


use App\Http\Domain\Company\Contracts\CompanyInterface;
use App\Http\Domain\Employee\Contracts\EmployeeInterface;
use App\Http\Domain\Support\Contracts\SalaryCalculatorInterface;
use App\Http\Domain\Support\Contracts\TaxesInterface;

class VeneziaCompany implements CompanyInterface
{
    protected EmployeeInterface $employee;
    protected TaxesInterface $taxes;
    protected SalaryCalculatorInterface $salaryCalculator;

    public function setEmployee(EmployeeInterface $employee): static
    {
       $this->employee = $employee;
       return $this;
    }

    public function setTax(TaxesInterface $taxes): static
    {
        $this->taxes = $taxes;
        return $this;
    }

    public function setCalculator(SalaryCalculatorInterface $salaryCalculator): static
    {
        $this->salaryCalculator = $salaryCalculator;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function getSalaryAmount(): int
    {
        try {
            return $this->salaryCalculator->calculate($this->taxes, $this->employee);
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }

    }
}
