<?php

namespace App\Services\Hmac;

use App\Services\Hmac\Hmac;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;

class HmacRequest {

    public function send(Hmac $hmac): PromiseInterface|Response
    {
        return Http::withHeaders($hmac->getHmacHeader())->asJson()->post($hmac->getRequestUrl(), $hmac->body());
    }
}
