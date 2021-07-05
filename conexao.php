<?php

class Conexao{
	
	private $connection_string	= 'DRIVER={SQL Server};SERVER=SRV-BDGVDASA\SQL2012;DATABASE=Gvcollege_Facema';
	private $user 				= 'sa';
	private $pass				= '$@f17.1mA()RhUD$@%!';
	
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