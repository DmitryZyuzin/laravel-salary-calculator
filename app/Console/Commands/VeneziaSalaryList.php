<?php

namespace App\Console\Commands;

use App\Http\Domain\Company\VeneziaCompany;
use App\Http\Domain\Employee\Contracts\EmployeeInterface;
use App\Http\Domain\Employee\Employee;
use App\Http\Domain\Support\PersonalIncomeTax;
use App\Http\Domain\Support\VeneziaSalaryCalculator;
use Illuminate\Console\Command;

class VeneziaSalaryList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:venezia_salary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Расчет зарплаты для действующих сотрудников Venezia Stone';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle()
    {

        $employee_collection = collect([]);

        $employee = (new Employee())
            ->setDescription('Алесе 26 лет, у нее двое детей, ее оклад – 150’000 руб.')
            ->setAge(26)
            ->setChildrenAmount(2)
            ->setSalaryAmount(150000);
        $employee_collection->push($employee);

        $employee = (new Employee())
            ->setDescription('Илье 52 года, он использует служебную машину, его оклад – 120’000 руб.')
            ->setAge(52)
            ->setCompanyCar(true)
            ->setSalaryAmount(120000);
        $employee_collection->push($employee);

        $employee = (new Employee())
            ->setDescription('Сергею 36 лет, у него трое детей, служебная машина и оклад 130’000 руб.')
            ->setAge(36)
            ->setChildrenAmount(2)
            ->setCompanyCar(true)
            ->setSalaryAmount(130000);
        $employee_collection->push($employee);

        $company = new VeneziaCompany();
        $comment = "Зарплата после вычета налогов составит: ";

        $employee_collection->each(function (EmployeeInterface $employee) use ($company,$comment) {
            $company->setTax(new PersonalIncomeTax());
            $company->setCalculator(new VeneziaSalaryCalculator());
            $company->setEmployee($employee);
            $salary_formatted = number_format($company->getSalaryAmount(), 0,"","'");

            $this->line('');
            $this->info($employee->getDescription());
            $this->error($comment . $salary_formatted . "₽");
        });

        return 0;
    }
}
