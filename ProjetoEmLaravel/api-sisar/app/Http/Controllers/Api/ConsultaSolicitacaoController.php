<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Hmac\{Hmac, HmacRequest};
use App\Enum\SisArApi;

class ConsultaSolicitacaoController extends Controller
{
    private Hmac $hmac;
    private HmacRequest $hmacRequest;
    
    public function __construct(Hmac $hmac, HmacRequest $hmacRequest){
        $this->hmac = $hmac;
        $this->hmacRequest = $hmacRequest;
    }

    public function consultaSolicitacao(Request $request){
        $this->hmac->setResources($request);
        $this->hmac->setServiceEndpoint(SisArApi::WEBSERVICE_API, SisArApi::DADOS_SOLICITACAO);
        $response = $this->hmacRequest->send($this->hmac);
        return $response->json();
    }

    public function consultaSituacaoSolicitacao(Request $request){
        $this->hmac->setResources($request);
        $this->hmac->setServiceEndpoint(SisArApi::WEBSERVICE_API, SisArApi::SITUACAO_SOLICITACAO);
        $response = $this->hmacRequest->send($this->hmac);
        return $response->json();
    }
}
