<?php
namespace App\Model;

use Respect\Validation\Validator as v;

class Rate extends BaseModel
{
    protected $amount;
    protected $ccy_from;
    protected $ccy_to;
    protected $exrate;
    protected $inverse;

    public function __construct($amount)
    {
        $this->setAmount($amount);
    }

    private function setAmount($amount)
    {
        if (!v::floatVal()->validate($amount)) {
            throw new \InvalidArgumentException('invalid rate: invalid amount', 10020);
        } elseif (!v::greaterThan(0)->validate($amount)) {
            throw new \InvalidArgumentException('invalid rate: amount must greater then 0', 10021);
        }
        $this->amount = $amount;
    }

    private function setCcyFrom(Currency $ccy_from)
    {
        $this->ccy_from = $ccy_from;
    }

    private function setCcyTo(Currency $ccy_to)
    {
        $this->ccy_to = $ccy_to;
    }

    private function setExRate($exrate)
    {
        if (!v::floatVal()->validate($exrate)) {
            throw new \InvalidArgumentException('update to invalid exrate', 10022);
        }
        $this->exrate = $exrate;
    }

    private function setInverse($inverse)
    {
        if (!v::floatVal()->validate($inverse)) {
            throw new \InvalidArgumentException('update to invalid inverse exrate', 10023);
        }
        $this->inverse = $inverse;
    }

    // public accessor/mutator
    public function setFrom($ccy_from)
    {
        $this->setCcyFrom($ccy_from);
    }

    public function addTo($ccy_to)
    {
        $this->setCcyTo($ccy_to);
    }

    public function updateExRate($exrate)
    {
        $this->setExRate($exrate);
    }

    public function updateInverse($inverse)
    {
        $this->setInverse($inverse);
    }

    public function get_amount()
    {
        return $this->amount;
    }

    public function get_ccy_from()
    {
        return $this->ccy_from;
    }

    public function get_ccy_to()
    {
        return $this->ccy_to;
    }

    public function get_exrate()
    {
        return $this->exrate;
    }

    public function get_inverse()
    {
        return $this->inverse;
    }
}
