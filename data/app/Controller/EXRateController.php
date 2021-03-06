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
    /**
     * @OA\Get(
     *     path="/convert-to",
     *     tags={"convert-to"},
     *     operationId="convertTo",
     *     @OA\Parameter(
     *         name="from",
     *         in="query",
     *         description="source currency convert from",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="to",
     *         in="query",
     *         description="target currency convert to",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="amount to convert",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="float"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful conversion",
     *         @OA\JsonContent(ref="#/components/schemas/Conversion")
     *         )
     *     )
     * )
     */
    public function convertTo(Request $request)
    {
        [
            'amount' => $amount,
            'from' => $ccy_from,
            'to' => $ccy_to,
        ] = filter_var_array($request->get(), [
            'amount' => FILTER_SANITIZE_STRING,
            'from' => FILTER_SANITIZE_STRING,
            'to' => FILTER_SANITIZE_STRING,
        ]);

        try {
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
