<?php


namespace App\Http\Domain\Support\Contracts;


interface TaxesInterface
{
    public function setTaxPercentage(int $value): static;

    public function getTaxPercentage();
}
