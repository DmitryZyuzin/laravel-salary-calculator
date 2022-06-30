<?php

namespace Tests\Unit;

use App\Http\Domain\Company\VeneziaCompany;
use App\Http\Domain\Employee\Employee;
use App\Http\Domain\Support\PersonalIncomeTax;
use Tests\TestCase;
use Faker\Factory as Faker;

class CalculatorClassesTest extends TestCase
{
    /**
     * Объект компании инициализируется
     *
     * @return void
     */
    public function test_company_object_is_ok()
    {

        $object = new VeneziaCompany();
        $this->assertIsObject($object);
    }

    /**
     * Объект НДФЛ инициализируется
     *
     * @return void
     */
    public function test_taxes_object_is_ok()
    {

        $object = new PersonalIncomeTax();
        $this->assertIsObject($object);
    }

    /**
     * Объект Сотрудника инициализируется
     *
     * @return void
     */
    public function test_empolyee_object_is_ok()
    {

        $object = new Employee();
        $this->assertIsObject($object);
    }

    /**
     * Объект Сотрудника устанавливает параметры
     *
     * @return void
     */
    public function test_empolyee_object_is_fillable()
    {
        $faker = Faker::create("ru_RU");

        $employee = new Employee();
        $employee->setDescription($faker->name())
            ->setAge($faker->randomDigit())
            ->setCompanyCar($faker->boolean)
            ->setSalaryAmount($faker->randomNumber(6));

        $this->assertIsObject($employee);
    }

    /**
     * Объект компании при
     *
     * @return void
     */
    public function test_company_set_taxes_is_ok()
    {

        $company = new VeneziaCompany();

        $this->assertIsObject($company);
    }
}
