<?php

require_once "vendor/autoload.php";
use Comtele\Services\TokenService;
const API_KEY = ""; // Aqui você irá inserir a chave disponibilizada pelo Comtele

$numero = isset($params['numero']) != '' ? $params['numero'] : '';
$token  = isset($params['token'])  != '' ? $params['token']  : '';

$tokenService = new TokenService(API_KEY);

if($action == "sentToken"){
	$result = $tokenService->send_totken(
		$numero,  // PhoneNumber: Numero de telefone que vai ser enviado o token via SMS.
		"Unifacema"     // Prefix: Identificação da empresa que aparecerá no corpo da mensagem. 
	);
	echo json_encode($result);
}

if($action == "validToken"){
	$result = $tokenService->validate_token(
	  $token   // TokenCode: Token que o cliente informou e deve ser validado pela Comtele.
	);
	echo json_encode($result);
	
}


	
?>
