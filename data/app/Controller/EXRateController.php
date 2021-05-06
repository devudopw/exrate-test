<?php
namespace App\Controller;

use support\Request;
use support\bootstrap\Log;
use App\Factory\VendorRatesFactory;
use App\Model\Rate;
use App\JSONAPI\Schema\ConversionSchema;
use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Schema\Error;

class EXRateController
{
    public function convertTo(Request $request)
    {
        extract(array_map("htmlspecialchars", $request->get()), EXTR_PREFIX_ALL, 'qs');

        try {
            $ccy_from = filter_var($qs_from, FILTER_SANITIZE_STRING);
            $ccy_to = filter_var($qs_to, FILTER_SANITIZE_STRING);
            $amount = filter_var($qs_amount, FILTER_SANITIZE_STRING);
            $rates_provider = VendorRatesFactory::create($amount);
            $rates_provider->setFrom($ccy_from);
            $converted = $rates_provider->convertTo($ccy_to);
            Log::info(sprintf('converting %1$s to %2$s with amount %3$s', $ccy_from, $ccy_to, $amount));
        } catch (\Exception $e) {
            $err_message = sprintf('something wrong when executing: %1$s', __FUNCTION__);
            $error = new Error(null, null, null, '400', $e->getCode(), $e->getMessage(), $err_message);
            Log::error('---------------ERROR');
            Log::error(sprintf('%1$s:%2$s', $e->getCode(), $e->getMessage()));
            Log::error($err_message);
            return jsonapierr(Encoder::instance(), $error, 400);
        }

        $encoder = Encoder::instance([
            Rate::class => ConversionSchema::class,
        ]);

        return jsonapi($encoder, $converted);
    }
}
