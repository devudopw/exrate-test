<?php
namespace App\Factory;

use App\RatesProvider\VendorRates;

class VendorRatesFactory extends RateProviderFactory
{
    public static function create($amonut)
    {
        return new VendorRates($amonut);
    }
}
