<?php

namespace App\Console\Commands;

use App\Http\Domain\Company\VeneziaCompany;
use App\Http\Domain\Employee\Employee;
use App\Http\Domain\Support\PersonalIncomeTax;
use App\Http\Domain\Support\VeneziaSalaryCalculator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * Class CustomSalarayCalculator
 * @package App\Console\Commands
 */
class CustomSalarayCalculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:custom_salary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Расчет зарплаты для нового сотрудника Venezia Stone';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle()
    {

        $employee = new Employee();
        $this->line('');
        $this->line('Расчет зарплаты для сотрудника Venezia Stone');
        $employee->setDescription($this->validateAsk(function() {
            return $this->ask('Имя сотрудника');
            }, ['name','required|string|min:3']));

        $employee->setAge( $this->validateAsk(function() {
            return $this->ask('Возраст сотрудника');
            }, ['age','required|integer|min:18|max:75']));

        $employee->setChildrenAmount($this->validateAsk(function() {
            return $this->ask('Введите кол-во детей');
            }, ['children','required|integer|min:0|max:10']));

        $employee->setCompanyCar( $this->validateAsk(function() {
            return $this->ask('Использует корпоративное авто?' . PHP_EOL
                . ' 1 - Да'. PHP_EOL
                . ' 0 - нет');
            }, ['company_car','required|boolean|min:0|max:1']));

        $employee->setSalaryAmount( $this->validateAsk(function() {
            return $this->ask('Зарплата сотрудника до вычета налогов');
        }, ['salary','required|integer|min:13890|max:300000']));

        $company = new VeneziaCompany();
        $company->setTax(new PersonalIncomeTax());
        $company->setEmployee($employee);
        $company->setCalculator(new VeneziaSalaryCalculator());

        $comment = "Зарплата {$employee->getDescription()} после вычета налогов составит: ";
        $salary_formatted = number_format($company->getSalaryAmount(), 0,"","'");
        $this->error($comment . $salary_formatted . "₽");
        return 0;
    }

    /**
     * Validate an input.
     *
     * @param  mixed   $method
     * @param  array   $rules
     * @return string
     */
    public function validateAsk($method, $rules)
    {
        $value = $method();
        $validate = $this->validateInput($rules, $value);
        if ($validate !== true) {
            $this->warn($validate);
            $value = $this->validateAsk($method, $rules);
        }
        return $value;
    }
    public function validateInput($rules, $value)
    {
        $validator = Validator::make([$rules[0] => $value], [ $rules[0] => $rules[1] ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return $error->first($rules[0]);
        }else{
            return true;
        }
    }
}
