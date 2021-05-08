<?php
use support\Response;
use Respect\Validation\Validator as v;

function jsonapi($encoder, $data, $status = 200)
{
    if (v::intVal()->between(400, 499)->validate($status)) {
        $data = $encoder->encodeError($data);
    } else {
        $data = $encoder->encodeData($data);
    }
    return new Response($status, ['Content-Type' => 'application/vnd.api+json'], $data);
}

function jsonapierr($encoder, $data, $status = 400)
{
    return jsonapi($encoder, $data, $status);
}
