<?php

/**
 * recuperar senha do banco de dados da solicitacao
 */
$senhaEnc = "base64";

/**
 * recuperar key usada na criptografia simetrica do banco
 * em DEV se encontra na config security.cipherData.key do app.ini
 * em HOM consultar a config
 */
$keyCipherDataBase = 'Man77NucHa3$BoGgy%KOto';


/**
* Iniciar recurso de criptografia
*/
$td = mcrypt_module_open('tripledes', '', 'ecb', '');
$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
mcrypt_generic_init($td, $keyCipherDataBase, $iv);

/**
* Decodificar base64 e decriptografar
*/
$senha = mdecrypt_generic($td, base64_decode($senhaEnc));

/**
* Liberar recurso de criptografia
*/
mcrypt_generic_deinit($td);
mcrypt_module_close($td);

var_dump($senha);
?>