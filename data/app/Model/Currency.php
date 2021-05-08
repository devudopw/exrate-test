<?php
namespace App\Model;

use Respect\Validation\Validator as v;

class Currency extends BaseModel
{
    protected $title;
    protected $code;
    protected $country;
    protected $symbol;

    public function __construct($code)
    {
        $this->set_code($code);
    }

    private function set_code($code)
    {
        if (!v::currencyCode()->validate($code)) {
            throw new \InvalidArgumentException('invalid currency code', 10010);
        }
        $this->code = $code;
    }

    public function get_code()
    {
        return $this->code;
    }
}
