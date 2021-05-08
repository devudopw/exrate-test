<?php
namespace App\RatesProvider;

use App\Model\Rate;
use App\Model\Currency;

abstract class AbstractRatesProvider implements RatesProviderInterface
{
    protected $rate;

    public function __construct($amount)
    {
        $this->rate = new Rate($amount);
    }

    public function setFrom($ccy_from)
    {
        $this->rate->setFrom(new Currency($ccy_from));
        return $this;
    }

    public function convertTo($ccy_to)
    {
        $this->rate->addTo(new Currency($ccy_to));
        $quote_rate = $this->quoteRates($this->rate);
        $this->rate->updateExRate($quote_rate->exrate);
        $this->rate->updateInverse($quote_rate->inverse);
        return $this->rate;
    }
}
