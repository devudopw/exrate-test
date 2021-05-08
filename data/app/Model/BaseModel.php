<?php
namespace App\Model;

class BaseModel
{
    public function __get($prop)
    {
        $method = 'get_'.$prop;
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new \ErrorException('undefined accessor to property "'.$prop.'"');
    }
}
