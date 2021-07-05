<?php

class Data{
	private $codigoPessoa;
	private $conexao;
	
	public function __construct($codigoPessoa) {
		$bd = new Conexao;
		
		$this->codigoPessoa = $codigoPessoa;
		$this->conexao 		= $bd->conectar();
	}
	
	public function isUpdate(){
		$retorno= false;
		$sql	= "SELECT 1 FROM PAD_PESSOA WHERE Atualizacao = 1 AND CODIGOPESSOA = $this->codigoPessoa";
		
		if($query  = odbc_exec($this->conexao, $sql)){ 
			if(odbc_num_rows($query) == 1){
				$retorno = true;
			}
		}
		
		return $retorno;
	}
	
	public function getStatusEnvio(){
		$retorno= 0;		
		$sql 	= "SELECT STATUS_ENV FROM FCO_PESSOAATUALIZACAO WHERE CODIGOPESSOA = $this->codigoPessoa";

		try{		  
			$query  = odbc_exec($this->conexao, $sql);
			if(odbc_num_rows($query) > 0){
				$objeto = odbc_fetch_object($query);
				$retorno= $objeto->STATUS_ENV;
			}
		}catch(Exception $e){}
		
		return $retorno;
	}
	
	public function getDadosPessoa(){
		$retorno= null;		
		$sql 	= "SELECT DISTINCT CPF,REPLACE(REPLACE(CPF,'.',''),'-','') AS CPFI,A.NOME,LOGINPESSOA,CASE SEXO WHEN 'M' THEN 'Masculino' WHEN 'F' THEN 'Feminino' ELSE '' END AS SEXO,EMAIL,DATANASCIMENTO,CELULAR FROM VW_NAAF_ALUNO_INTEGRACAO A, PAD_PESSOA B WHERE A.CODIGOPESSOA = B.CODIGOPESSOA AND A.CODIGOPESSOA = $this->codigoPessoa";

		try{		  
			$query  = odbc_exec($this->conexao, $sql);
			if(odbc_num_rows($query) > 0){
				$retorno = odbc_fetch_object($query);
			}
		}catch(Exception $e){}
		
		return $retorno;
	}
	
	public function insertPessoa($codigoPessoa,$nome){	
		$bd = new Conexao;
		$conexao = $bd->conectar();
		
		$sql = "INSERT INTO PAD_PESSOA(CODIGOPESSOA,NOME,DATACADASTRO,TIPOPESSOA,TIPOVINCULOENDERECO,CODIGOPESSOAVINCULOENDERECO,CODIGOUSUARIO,DATAATUALIZACAO,RECEBECOMUNICADO,POSSUICHEQUEIRREGULAR,LOGINPESSOA,SENHAPESSOA)
				VALUES ($codigoPessoa,'$nome',GETDATE(),'F',1,$codigoPessoa,8852,GETDATE(),0,0,'','')";
		try{		
			if(odbc_exec($conexao, $sql)){
				return true;
			}else{
				return false;
			}
			
		}catch(Exception $e){
			return false;
		}

		$bd->desconectar($conexao);
	}
	
	public function insertPessoaFisica($codigoPessoa,$sexo,$grauInstrucao,$paisOrigem = 'NULL',$ufOrigem = 'NULL',$cidadeOrigem = 'NULL',$estadoCivil = 'NULL',$pai = 'NULL',$mae = 'NULL',$conjuge = 'NULL',$etinia = 'NULL',$cpf = 'NULL',$rg = 'NULL',$rgDataExpedi = 'NULL',$rgOrgExpedi = 'NULL',$rgUf = 'NULL',$dtNascimento = 'NULL',$nTituloEleit = 'NULL',$zona = 'NULL',$secao = 'NULL',$reservista = 'NULL',$comarca = 'NULL',$livro = 'NULL',$lolha = 'NULL',$cNumero = 'NULL'){	
		
		$bd = new Conexao;
		$conexao = $bd->conectar();
		
		//valida Número do Titulos Eleitor
		if($nTituloEleit != "" && $nTituloEleit != "NULL" && $nTituloEleit != NULL){
			$nTituloEleit.= str_repeat(' ',15-strlen($nTituloEleit));
			$nTituloEleit = "'".$nTituloEleit."'";
		}
		
		//valoda Zone a Seção do Titulos Eleitor
		if(($zona != "" && $zona != "NULL" && $zona != NULL) && ($secao != "" && $secao != "NULL" && $secao != NULL)){
			$zonaSecao = str_repeat(0,3-strlen($zona)).$zona.'/'.str_repeat(0,4-strlen($secao)).$secao;
			$zonaSecao = str_repeat(" ",10-strlen($zonaSecao));
			$zonaSecao = "'".$zonaSecao."'";
		}else{
			$zonaSecao = "NULL";
		}
		
		//valoda Reservista
		if($reservista != "" && $reservista != "NULL" && $reservista != NULL){
			$reservista.= str_repeat(' ',12-strlen($reservista));
			$reservista = "'".$reservista."'";
		}
		
		//Valida CPF
		if($cpf != "" && $cpf != "NULL" && $cpf != NULL){$cpf= "'".$cpf."'";}
		
		//Valida RG
		if($rg != "" && $rg != "NULL" && $rg != NULL){$rg= "'".$rg."'";}
		
		//Valida Órgão Expeditor
		if($rgOrgExpedi != "" && $rgOrgExpedi != "NULL" && $rgOrgExpedi != NULL){$rgOrgExpedi= "'".$rgOrgExpedi."'";}
		
		//Valida Data de Expedição do RG
		if($rgDataExpedi != "" && $rgDataExpedi != "NULL" && $rgDataExpedi != NULL){
			$rgDia		  = substr($rgDataExpedi,0,2);
			$rgMes		  = substr($rgDataExpedi,3,2);
			$rgAno 		  = substr($rgDataExpedi,6,4);
			$rgDataExpedi = $rgAno.'-'.$rgMes.'-'.$rgDia.' 00:00:00.000';
			$rgDataExpedi = "'".$rgDataExpedi."'";
		}
		
		//Valida Data de Nascimento
		if($dtNascimento != "" && $dtNascimento != "NULL" && $dtNascimento != NULL){
			$nsDia		  = substr($dtNascimento,0,2);
			$nsMes		  = substr($dtNascimento,3,2);
			$nsAno 		  = substr($dtNascimento,6,4);
			$dtNascimento = $nsAno.'-'.$nsMes.'-'.$nsDia.' 00:00:00.000';
			$dtNascimento = "'".$dtNascimento."'";
		}
		
		//Valida Comarca
		if($comarca != "" && $comarca != "NULL" && $comarca != NULL){$comarca= "'".$comarca."'";}
		
		//Valida Livro
		if($livro != "" && $livro != "NULL" && $livro != NULL){$livro= "'".$livro."'";}
		
		//Valida Folha
		if($lolha != "" && $lolha != "NULL" && $lolha != NULL){$lolha= "'".$lolha."'";}
		
		//Valida Numero de Certidão
		if($cNumero != "" && $cNumero != "NULL" && $cNumero != NULL){$cNumero= "'".$cNumero."'";}
				
		$sql = "INSERT INTO PAD_PESSOAFISICA(CODIGOPESSOA,CODIGOPAIS,CODIGOUFNASCIMENTO,CODIGOCIDADENASCIMENTO,CODIGOESTADOCIVIL,CODIGOGRAUINSTRUCAO,CODIGOPAI,CODIGOMAE,CODIGOCONJUGE,CODIGOETNIA,CPF,IDENTIDADE,DATAEXPEDICAO,ORGAOEXPEDIDOR,IDUFEXPEDIDOR,DATANASCIMENTO,SEXO,TITULOELEITORAL,ZONASECAOELEITORAL,CODIGORESERVISTA,FALECIDO,TIPOENDERECOCORRESPONDENCIA,CERTIDAONASCIMENTOCOMARCA,CERTIDAONASCIMENTOLIVRO,CERTIDAONASCIMENTOFOLHA,CERTIDAONASCIMENTONUMERO,EMANCIPADO,NATURALIZADO,TIPOCERTIDAOCIVIL)
				VALUES($codigoPessoa,$paisOrigem,$ufOrigem,$cidadeOrigem,$estadoCivil,$grauInstrucao,$pai,$mae,$conjuge,$etinia,$cpf,$rg,$rgDataExpedi,$rgOrgExpedi,$rgUf,$dtNascimento,'$sexo',$nTituloEleit,$zonaSecao,$reservista,0,'P',$comarca,$livro,$lolha,$cNumero,0,0,1)";
		try{		
			if(odbc_exec($conexao, $sql) && 1 == 1){
				return true;
			}else{
				return false;
			}
			
		}catch(Exception $e){
			return false;
		}

		$bd->desconectar($conexao);
	}
		
	public function insertPessoaContato($codigoContato,$codigoTipoContato,$codigoPessoa,$contato,$codigoArea = "NULL"){	
		$bd = new Conexao;
		$conexao = $bd->conectar();
		
		//Valida Codigo de Area
		if($codigoArea != "" && $codigoArea != "NULL" && $codigoArea != NULL){$codigoArea= "'".$codigoArea."'";}
		
		$sql = "INSERT INTO PAD_PESSOACONTATO (CODIGOCONTATO,CODIGOTIPOCONTATOITEM,CODIGOPESSOA,CONTATO,CODIGOAREA,DATAATUALIZACAO,CODIGOUSUARIO,UTILIZACOMOLOGIN,CONTATOPRINCIPAL,OBSERVACAO)
				VALUES ($codigoContato,$codigoTipoContato,$codigoPessoa,'$contato',$codigoArea,GETDATE(),8852,0,0,CONCAT('Inserido pela Atualizacao aut. portal do aluno - EQ: 93 - ',CONVERT(VARCHAR(10),GETDATE(),103)))";
		try{		
			if(odbc_exec($conexao, $sql)){
				return true;
			}else{
				return false;
			}
			
		}catch(Exception $e){
			return false;
		}

		$bd->desconectar($conexao);
	}
	
	public function getDadosEnquete($codigoEnquete){
		$retorno= null;		
		$sql 	= "SELECT DESCRICAOENQUETE AS titulo,SUBTITULO AS subtitulo FROM ENQ_ENQUETE WHERE CODIGOENQUETE = $codigoEnquete";

		try{		  
			$query  = odbc_exec($this->conexao, $sql);
			if(odbc_num_rows($query) > 0){
				$retorno = odbc_fetch_object($query);
			}
		}catch(Exception $e){}
		
		return $retorno;
	}
		
	public function getQuestaoEnquete($codigoEnquete){
		
		$sql = "SELECT CODIGOQUESTAO,CODIGOTIPOQUESTAO,DESCRICAOQUESTAO,RESPOSTAOBRIGATORIA,NUMEROQUESTAO
				FROM ENQ_QUESTAO WHERE CODIGOENQUETE = $codigoEnquete
				ORDER BY NUMEROQUESTAO";
		
		$array = array();
		try{	  
			$query = odbc_exec($this->conexao, $sql);
			while($objeto = odbc_fetch_object($query)){
				array_push($array, $objeto);                 
			}
		}catch(Exception $e){}
		
		return $array;	 
	}
	
	public function getAlternativaEnquete($codigoAlternativa){
		
		$sql = "SELECT CODIGOALTERNATIVA,DESCRICAOALTERNATIVA,NUMEROALTERNATIVA
				FROM ENQ_ALTERNATIVA
				WHERE CODIGOQUESTAO = $codigoAlternativa
				ORDER BY ORDEMALTERNATIVA";
		
		$array = array();
		try{	  
			$query = odbc_exec($this->conexao, $sql);
			while($objeto = odbc_fetch_object($query)){
				array_push($array, $objeto);                 
			}
		}catch(Exception $e){}

		return $array;	 
	}
	
	public function insertRespostaEnquete($codigoResposta,$codigoPessoa,$codigoQuestao,$codigoAlternativa = "NULL",$discricaoResposta = "NULL"){	
	
		//Valida discrição Resposta
		if($discricaoResposta != "" && $discricaoResposta != "NULL" && $discricaoResposta != NULL){$discricaoResposta= "'".$discricaoResposta."'";}
		
		$sql = "INSERT ENQ_RESPOSTA (CODIGORESPOSTA,CODIGOALTERNATIVA,CODIGOQUESTAO,CODIGOPESSOA,DESCRICAORESPOSTA,DATAATUALIZACAO)
				VALUES ($codigoResposta,$codigoAlternativa,$codigoQuestao,$codigoPessoa,$discricaoResposta,GETDATE())";
				
		$sql = utf8_decode($sql);
		try{		
			if(odbc_exec($this->conexao, $sql)){
				return true;
			}else{
				return false;
			}
			
		}catch(Exception $e){
			return false;
		}
	}
	
	public function getProximoRegistro($tabela){	
	
		$sql = "DECLARE @PROXIMOREGISTRO INT
				EXEC ACDSP_PROXIMOREGISTROTABELA '$tabela',@PROXIMOREGISTRO OUTPUT
				SELECT @PROXIMOREGISTRO ID";
		
		$retorno = 0;
		try{	  
			$query = odbc_exec($this->conexao, $sql);
			while($objeto = odbc_fetch_object($query)){
				$retorno = $objeto->ID;                 
			}
		}catch(Exception $e){}

		return $retorno;
	}
	
	public function setUpdate(){
		$retorno= false;
		$sql	= "UPDATE PAD_PESSOA SET Atualizacao = 0 WHERE CODIGOPESSOA = $this->codigoPessoa";
		
		if(odbc_exec($this->conexao, $sql)){
			return true;
		}else{
			return false;
		}
	}
	
	public function insertPessoaFidelimax($cpf,$nome,$sexo,$email,$dtNascimento,$telefone){
		$retorno= null;		
		$sql 	= " DECLARE @CODIGORESPOSTA INT,@MENSAGEM VARCHAR(994)
					EXEC DBO.SP_FideliMax_CadastrarConsumidor '$cpf','$nome','$sexo','$email','$dtNascimento','$telefone',@CODIGORESPOSTA OUTPUT,@MENSAGEM OUTPUT
					SELECT @CODIGORESPOSTA AS codResposta,@MENSAGEM AS resposta";
		try{		  
			$query  = odbc_exec($this->conexao, $sql);
			$retorno = odbc_fetch_object($query);

		}catch(Exception $e){}
		
		return $retorno;
	}
	
	public function insertLogFidelimax($cpf,$msg){	
		$bd = new Conexao;
		$conexao = $bd->conectar();
			
		$sql = "INSERT INTO FIDELIMAX_LOG VALUES ('$cpf','Cadastrado',GETDATE(),'$msg')";
		try{		
			if(odbc_exec($conexao, $sql)){
				return true;
			}else{
				return false;
			}
			
		}catch(Exception $e){
			return false;
		}

		$bd->desconectar($conexao);
	}
	
}

?>