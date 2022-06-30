<?php

namespace Tests\Feature;

use App\Http\Domain\Company\VeneziaCompany;
use App\Http\Domain\Employee\Employee;
use App\Http\Domain\Support\PersonalIncomeTax;
use App\Http\Domain\Support\VeneziaSalaryCalculator;
use Tests\TestCase;
use Faker\Factory as Faker;


class VeneziaSalaryCalculatorTest extends TestCase
{

    /**
     * Проверка расчета скидки налога по кол-ву детей
     * @throws \Exception
     */
    public function test_venezia_salary_tax_reduce_children_equals_18()
    {

        $faker = Faker::create("ru_RU");

        $employee = (new Employee())
            ->setDescription($faker->name())
            ->setAge($faker->numberBetween(0,49))
            ->setChildrenAmount($faker->numberBetween(2,10))
            ->setSalaryAmount($faker->randomNumber(6));

        $personal_taxes = new PersonalIncomeTax();
        $employee_salary = (new VeneziaCompany())
            ->setTax($personal_taxes)
            ->setEmployee($employee)
            ->setCalculator(new VeneziaSalaryCalculator())
            ->getSalaryAmount();

        $taxes_percentage = $personal_taxes->getTaxPercentage();
        $this->assertEquals(18,$taxes_percentage);
    }

    /**
     * Проверка расчета начисления за возраст сотрудника
     * @throws \Exception
     */
    public function test_venezia_salary_age_bonus()
    {

        $age_bonus_multiplier = config('venezia_stone.personal_taxes.age_bonus_multiplier');

        $faker = Faker::create("ru_RU");
        $salary_amount = $faker->randomNumber(6);

        $employee = (new Employee())
            ->setDescription($faker->name())
            ->setAge($faker->numberBetween(50,75))
            ->setChildrenAmount($faker->numberBetween(0,1))
            ->setSalaryAmount($salary_amount);

        $personal_taxes = new PersonalIncomeTax();
        $personal_taxes->setTaxPercentage(0);
        $employee_salary = (new VeneziaCompany())
            ->setTax($personal_taxes)
            ->setEmployee($employee)
            ->setCalculator(new VeneziaSalaryCalculator())
            ->getSalaryAmount();

        $test_salary_amount = intval($salary_amount * $age_bonus_multiplier);
        $this->assertEquals($test_salary_amount,$employee_salary);
    }

    /**
     * Проверка расчета удержания за автомобиль компании
     * @throws \Exception
     */
    public function test_venezia_salary_company_car_discount()
    {

        $company_car_discount = config('venezia_stone.personal_taxes.company_car_discount');

        $faker = Faker::create("ru_RU");
        $salary_amount = $faker->randomNumber(6);

        $employee = (new Employee())
            ->setDescription($faker->name())
            ->setAge($faker->numberBetween(0,18))
            ->setChildrenAmount($faker->numberBetween(0,1))
            ->setCompanyCar(true)
            ->setSalaryAmount($salary_amount);

        $personal_taxes = new PersonalIncomeTax();
        $personal_taxes->setTaxPercentage(0);

        $employee_salary = (new VeneziaCompany())
            ->setTax($personal_taxes)
            ->setEmployee($employee)
            ->setCalculator(new VeneziaSalaryCalculator())
            ->getSalaryAmount();

        $test_salary_company_car_discount = $salary_amount - $employee_salary;
        $this->assertEquals($test_salary_company_car_discount,$company_car_discount);
    }

    /**
     * Общая работоспособность калькулятора
     *
     * @return void
     * @throws \Exception
     */
    public function test_venezia_calculator_is_calculate_true()
    {

        $faker = Faker::create("ru_RU");

        $employee = (new Employee())
            ->setDescription($faker->name())
            ->setAge($faker->numberBetween(0,49))
            ->setChildrenAmount($faker->numberBetween(0,10))
            ->setCompanyCar(true)
            ->setSalaryAmount($faker->randomNumber(6));

        $company = new VeneziaCompany();
        $result = $company->setTax(new PersonalIncomeTax())
            ->setEmployee($employee)
            ->setCalculator(new VeneziaSalaryCalculator())
            ->getSalaryAmount();

        $this->assertIsInt($result);

    }
}
