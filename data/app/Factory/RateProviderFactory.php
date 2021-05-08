<?php
namespace App\Factory;

abstract class RateProviderFactory
{
    abstract public static function create($amount);
}
