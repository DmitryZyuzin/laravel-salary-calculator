<?php


namespace App\Http\Domain\Support;


use App\Http\Domain\Support\Contracts\TaxesInterface;

/**
 * Персональный налог, базовая ставка 20%
 * Class PersonalIncomeTax
 * @package App\Http\Domain\Support
 */
class PersonalIncomeTax implements TaxesInterface
{
    protected int $tax_amount = 20;

    public function setTaxPercentage(int $value): static
    {
        $this->tax_amount = $value;
        return $this;
    }

    public function getTaxPercentage(): int
    {
        return $this->tax_amount;
    }


}
