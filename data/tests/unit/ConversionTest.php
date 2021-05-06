<?php
use PHPUnit\Framework\TestCase;
use App\Factory\VendorRatesFactory;

class ConversionTest extends TestCase {
	public function testInvalidAmountThrowsException()
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionCode(10020);
		$amount = 'invalidamount';
		VendorRatesFactory::create($amount);
	}

	public function testNonFloatAmountThrowsException()
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionCode(10021);
		$amount = -1;
		VendorRatesFactory::create($amount);
	}

	public function testInvalidFromCurrencyThrowsException()
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionCode(10010);
		$ccy_from = 'ABC';
		$amount = 1;
		$rates_provider = VendorRatesFactory::create($amount);
		$rates_provider->setFrom($ccy_from);
	}

	public function testInvalidToCurrencyThrowsException()
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionCode(10010);
		$ccy_from = 'USD';
		$ccy_to = 'ABC';
		$amount = 1;
		$rates_provider = VendorRatesFactory::create($amount);
		$rates_provider->setFrom($ccy_from);
		$rates_provider->convertTo($ccy_to);
	}
}
