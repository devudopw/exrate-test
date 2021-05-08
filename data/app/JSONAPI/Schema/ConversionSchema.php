<?php
namespace App\JSONAPI\Schema;

use Neomerx\JsonApi\Contracts\Schema\ContextInterface;
use Neomerx\JsonApi\Schema\BaseSchema;

/**
 * @OA\Schema(
 *   schema="Conversion",
 *   @OA\Property(property="data", ref="#/components/schemas/data")
 * )
 * @OA\Schema(
 *   schema="data",
 *   @OA\Property(property="type", type="string", default="conversion"),
 *   @OA\Property(property="attributes", ref="#/components/schemas/attributes")
 * )
 */

class ConversionSchema extends BaseSchema
{
    public function getType(): string
    {
        return 'conversion';
    }

    public function getId($rate): ?string
    {
        return null;
    }

    /**
     * @OA\Schema(
     *   schema="attributes",
     *   @OA\Property(
     *     property="converted",
     *     type="string"
     *   ),
     *   @OA\Property(
     *     property="amount",
     *     type="number",
     *     format="float"
     *   ),
     *   @OA\Property(
     *     property="from",
     *     type="string"
     *   ),
     *   @OA\Property(
     *     property="to",
     *     type="string"
     *   ),
     *   @OA\Property(
     *     property="exrate",
     *     type="number",
     *     format="float"
     *   ),
     *   @OA\Property(
     *     property="inverse",
     *     type="number",
     *     format="float"
     *   ),
     * )
     *
     * @param      <type>                                              $rate     The rate
     * @param      \Neomerx\JsonApi\Contracts\Schema\ContextInterface  $context  The context
     *
     * @return     array|iterable                                      The attributes.
     */
    public function getAttributes($rate, ContextInterface $context): iterable
    {
        return [
            'converted' => (float) bcmul($rate->amount, $rate->exrate, 10),
            'amount' => $rate->amount,
            'from' => $rate->ccy_from->code,
            'to' => $rate->ccy_to->code,
            'exrate' => $rate->exrate,
            'inverse' => $rate->inverse,
        ];
    }

    public function getRelationships($resource, ContextInterface $context): iterable
    {
        return [];
    }

    public function getLinks($resource): iterable
    {
        return [];
    }
}
