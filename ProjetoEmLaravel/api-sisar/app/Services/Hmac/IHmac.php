<?php

namespace App\Services\Hmac;
use Illuminate\Http\Request;

interface IHmac
{
    public function setResources(Request $resources);
    public function getMessage();
    public function getHKey(): string;
    public function getRequestUrl();
    public function getHmac(): string;
    public function getHmacHeader(): array;
    public function getBaseUrl();
    public function setServiceEndpoint(SisArApi $service, SisArApi $endpoint);
    //public function send();
}
