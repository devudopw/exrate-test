<?php
namespace App\RatesProvider;

use App\Model\Rate;

interface RatesProviderInterface
{
    public function quoteRates(Rate $rate);
}
