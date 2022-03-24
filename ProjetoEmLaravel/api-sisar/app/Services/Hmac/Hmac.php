<?php

namespace App\Services\Hmac;

use Illuminate\Http\Request;
use App\Enum\SisArApi;

class Hmac 
{
    private string $method;
    private mixed $hmacVersion;
    private int $clientId;
    protected Request $resources;
    private int $nonce;
    private $uri_endpoint;
    private SisArApi $service;
    
    public function __construct(Request $request)
    {
        $this->nonce = time();
        $this->method = $request->method();
        $this->clientId = config("hmac.client_id");
        $this->hmacVersion = config("hmac.version");
    }

    public function setResources($resources)
    {
        $this->resources = $resources;
    }
    public function setServiceEndpoint($service,$endpoint){
        $this->uri_endpoint = config("services.sisar.{$service->value}.{$endpoint->value}");
    }
    public function getMessage():string
    {
        return json_encode($this->resources->search);
    }
    public function getSignData(){
        return $this->method . $this->getBaseUrl() . $this->uri_endpoint . $this->getMessage();
    }

    public function getRequestUrl(){
        return $this->getBaseUrl() . $this->uri_endpoint;
    }

    public function getBaseUrl()
    {
        return config("environment.dev.base_url");
    }
    public function getKey(){
        return config("environment.dev.hmac_key.webservice_api");
    }
    public function getHKey(): string{
        return $this->nonce . $this->getKey();
    }
    public function getHmac(){
        return hash('sha256', hash('sha256', $this->getHKey()) . hash('sha256', $this->getHKey() . $this->getSignData()) );
    }
    public function getHmacHeader():array{
        return array('HMAC-Authentication' => $this->hmacVersion . ":" . $this->clientId . ":" . $this->nonce . ":" . $this->getHmac());
    }
    public function body():array
    {
        return (array)$this->resources->search;
    }

}
