<?php
namespace App\RatesProvider;

use App\Model\RateDAO;

class VendorRates extends AbstractRatesProvider
{
    public function quoteRates($rate)
    {
        $from = $rate->ccy_from->code;
        $to = $rate->ccy_to->code;
        $rateDAO = new RateDAO();
        return $rateDAO->findEXRate($from, $to);
    }
}
