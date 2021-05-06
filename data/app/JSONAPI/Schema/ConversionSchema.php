<?php
namespace App\JSONAPI\Schema;

use Neomerx\JsonApi\Contracts\Schema\ContextInterface;
use Neomerx\JsonApi\Schema\BaseSchema;

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
