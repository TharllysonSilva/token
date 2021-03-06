<?php

require_once "vendor/autoload.php";
use Comtele\Services\TokenService;
const API_KEY = ""; // Aqui você irá inserir a chave disponibilizada pelo Comtele

$numero = isset($params['numero']) != '' ? $params['numero'] : ''; //parametro responsavel por pegar o numero inserido no input de numero inserido
$token  = isset($params['token'])  != '' ? $params['token']  : ''; // parametro para verificar o token enviado pelo comtele

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

<!-- funciona cmo confirmador para verificação se realmente é o dono da conta que esta recebendo os dados --> 
