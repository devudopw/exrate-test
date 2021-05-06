<?php
namespace App\RatesProvider;

class ExchangeratesAPI extends AbstractRatesProvider
{
    public function quoteRates($rate)
    {
        $amount = $rate->amount;
        $from = $rate->ccy_from->code;
        $to = $rate->ccy_to->code;
        // set API Endpoint and API key
        $endpoint = '/v1/convert';
        $access_key = env('Exchangerates_API_KEY', '519360f04df9c2f5faec0223ee43a1db');

        // Initialize CURL:
        $request_url = sprintf('http://api.exchangeratesapi.io/%1$s?access_key=%2$s&amount=%3$f&from=%4$s&to=%5$s', $endpoint, $access_key, $amount, $from, $to);
        $ch = curl_init($request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        // return json_decode($json, true);
        return 1.23456789;
    }
}
