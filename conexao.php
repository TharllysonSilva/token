<?php

class Conexao{
	
	private $connection_string	= 'DRIVER={SQL Server};SERVER=SRV-BDGVDASA\SQL2012;DATABASE=Gvcollege_Facema';
	private $user 				= 'xxxxx'; //nome do usuario de acesso ao banco de dados
	private $pass				= 'XXXXXXXXXX'; //Sempre criptografar as suas senhas
	
	public function conectar(){
		try{
			$conexao = odbc_connect($this->connection_string, $this->user, $this->pass);
			return $conexao;
		}catch(Exception $e){
			die('Erreur : '.$e->getMessage());
		}		
	}
	
	public function desconectar($conexao){
		try{
			odbc_close($conexao);
		}catch(Exception $e){
			die('Erreur : '.$e->getMessage());
		}
	}
}

?>
