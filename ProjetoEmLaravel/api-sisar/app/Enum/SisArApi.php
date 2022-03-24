<?php

namespace App\Enum;

enum SisArApi: string
{
    //service
    case WEBSERVICE_API = "webservice_api";
    
    //endpoint
    case DADOS_SOLICITACAO = "dadosSolicitacao";
    case SITUACAO_SOLICITACAO = "situacaoSolicitacao";

    
}
