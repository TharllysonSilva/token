<?php
if($usuario = unserialize($_SESSION['usrs'])){

	//VARIAVEL
	$codigoPessoa = $usuario->codigoPessoa;
	
	//  Enquete
	$enquReposta	= isset($_POST['enquReposta']) 	&& trim($_POST['enquReposta'])  != ""  && $_POST['enquReposta'] 	!= "null"	? $_POST['enquReposta']	: 'NULL';
/*
	$cep		 = $_POST['cep'];
	$rua		 = utf8_decode($_POST['rua']);
	$nuber		 = $_POST['nuber'];
	$bairro		 = utf8_decode($_POST['bairro']);
	$cidade		 = utf8_decode($_POST['cidade']);
	$uf			 = utf8_decode($_POST['uf']);
	$ddd1		 = $_POST['ddd1'];
	$cel1		 = $_POST['cel1'];
	$ddd2		 = $_POST['ddd2'];
	$cel2		 = $_POST['cel2'];
	$ddd3		 = $_POST['ddd3'];
	$resi		 = $_POST['resi'];
	$email		 = utf8_decode($_POST['email']);
	$comp		 = utf8_decode($_POST['comp']);	

	//ARQUIVAR INFORMAÇÕES ANTERIORES
	$sql_ant = "UPDATE FCO_PESSOAATUALIZACAO
				SET
				ANT_CEP			 = PSE.CEP,
				ANT_ENDERECO	 = PSE.ENDERECO,
				ANT_NUMERO		 = PSE.NUMERO,
				ANT_CODIGOBAIRRO = PSE.CODIGOBAIRRO,
				ANT_CODIGOCIDADE = PSE.CODIGOCIDADE,
				ANT_CODIGOUF	 = CODIGOUF,
				ANT_COMPLEMENTO  = PSE.COMPLEMENTO,
				ANT_EMAIL		 = (SELECT TOP 1 PSC.CONTATO FROM PAD_PESSOACONTATO PSC WHERE PSC.CODIGOPESSOA = PSF.CODIGOPESSOA AND PSC.CODIGOTIPOCONTATOITEM = 6),
				ANT_CEL1		 = (SELECT TOP 1 PSC.CONTATO FROM PAD_PESSOACONTATO PSC WHERE PSC.CODIGOPESSOA = PSF.CODIGOPESSOA AND PSC.CODIGOTIPOCONTATOITEM = 8),
				ANT_CEL2		 = (SELECT TOP 1 PSC.CONTATO FROM PAD_PESSOACONTATO PSC WHERE PSC.CODIGOPESSOA = PSF.CODIGOPESSOA AND PSC.CONTATO NOT IN (SELECT TOP 1 PSC.CONTATO FROM PAD_PESSOACONTATO PSC WHERE PSC.CODIGOPESSOA = PSF.CODIGOPESSOA AND PSC.CODIGOTIPOCONTATOITEM = 8) AND PSC.CODIGOTIPOCONTATOITEM = 8),
				ANT_TEL			 = (SELECT TOP 1 PSC.CONTATO FROM PAD_PESSOACONTATO PSC WHERE PSC.CODIGOPESSOA = PSF.CODIGOPESSOA AND PSC.CODIGOTIPOCONTATOITEM = 7)
				
				FROM PAD_PESSOAFISICA PSF
				INNER JOIN PAD_PESSOAENDERECO PSE
				ON PSE.CODIGOPESSOA = PSF.CODIGOPESSOA
				WHERE FCO_PESSOAATUALIZACAO.CODIGOPESSOA = PSF.CODIGOPESSOA AND FCO_PESSOAATUALIZACAO.CODIGOPESSOA = $codigoPessoa";
	odbc_exec($conexao,$sql_ant);

	//UF
	$con1 = "SELECT TOP 1 CODIGOUF,SIGLA FROM PAD_UNIDADEFEDERACAO WHERE SIGLA = '$uf'";
	$sql_uf = odbc_exec ($conexao, $con1);
	while ($file1 = odbc_fetch_object($sql_uf)){ 
				 $codsiglo = $file1->CODIGOUF;			 
				 }
				 
	//CIDADE			 
	$con2 = "SELECT TOP 1 CODIGOCIDADE,NOME FROM PAD_CIDADE WHERE NOME = '$cidade'";
	$sql_cid = odbc_exec ($conexao, $con2);
	while ($file2 = odbc_fetch_object($sql_cid)){
				 $codcidade = $file2-> CODIGOCIDADE;
				 }
				 
	//BAIRRO

	//SELELECT REGISTROS E QNT REGISTROS 
	$con3 = "SELECT TOP 1 CODIGOBAIRRO, NOME FROM PAD_BAIRRO WHERE NOME = '$bairro' AND CODIGOCIDADE = '$codcidade'";
	$sql_bairro1 = odbc_exec ($conexao, $con3);
	$cont = odbc_num_rows($sql_bairro1);	

	/* desativado provisoriamente.
	//CONDICIONAL BAIRRO
	if ($cont == 0){

	//SE VERDADE

	//SELECT ULTIMO REGISTRO + 1
	$con4 = "SELECT TOP 1 CODIGOBAIRRO FROM PAD_BAIRRO ORDER BY CODIGOBAIRRO DESC";
	$sql_bairro2 = odbc_exec ($conexao, $con4);
	while ($file3 = odbc_fetch_object($sql_bairro2)){
				 $utcodbairro = $file3->CODIGOBAIRRO;
				 }
	$utcodba = $utcodbairro + 1	;

	//INSERT BAIRRO
	$con5 = "INSERT INTO PAD_BAIRRO(CODIGOBAIRRO,CODIGOCIDADE,NOME,CODIGOUSUARIO) VALUES ($utcodba,$codcidade,'$cidade',3)";
	odbc_exec ($conexao, $con5);

	$sql_padutr8 = "UPDATE PAD_ULTIMOREGISTRO SET ULTIMOREGISTRO = $utcodba WHERE NOMETABELA = 'PAD_BAIRRO'";
		odbc_exec ($conexao, $sql_padutr8);	

	//UPDATE BAIRRO
	$con6 = "UPDATE PAD_PESSOAENDERECO SET CODIGOBAIRRO = $utcodba WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $con6);

	//FIM
	}else{
	//SE ERRADO

	while ($file4 = odbc_fetch_object($sql_bairro1)){
		$codbairro = $file4->CODIGOBAIRRO;
	}
				 
	//UPDATE BAIRRO			 			 
	$con7 = "UPDATE PAD_PESSOAENDERECO SET CODIGOBAIRRO = $codbairro WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $con7);
	}

	//SQL UPDATE

	//UPDATE CEP			 
	$sql1 = "UPDATE PAD_PESSOAENDERECO SET CEP = '$cep' WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $sql1);

	//UPDATE ENDEREÇO
	$sql2 = "UPDATE PAD_PESSOAENDERECO SET ENDERECO = '$rua' WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $sql2);

	//UPDATE NUMERO
	$sql3 = "UPDATE PAD_PESSOAENDERECO SET NUMERO = '$nuber' WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $sql3);

	//UPDATE CIDARE
	$sql4 = "UPDATE PAD_PESSOAENDERECO SET CODIGOCIDADE = $codcidade WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $sql4);

	//UPDATE UF
	$sql5 = "UPDATE PAD_PESSOAENDERECO SET CODIGOUF = $codsiglo WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $sql5);

	//UPDATE COMPLEMENTO
	$sql6 = "UPDATE PAD_PESSOAENDERECO SET COMPLEMENTO = '$comp' WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $sql6);

	
	//CONTATO

	//SELECT ULTIMO REGISTRO + 1
	$cond9 = "SELECT TOP 1 CODIGOCONTATO FROM PAD_PESSOACONTATO ORDER BY CODIGOCONTATO DESC";
	$sql_codcot5 = odbc_exec ($conexao, $cond9);
	while ($file9 = odbc_fetch_object($sql_codcot5)){
		$utcodcont = $file9->CODIGOCONTATO;
	}

	$utreccon = $utcodcont + 1;

	$utreccon4 = $utcodcont + 4;

	// CEL 1
	if($cel1 != ""){

	//DELETAR CONTATO ANTIGO - CELULAR
		 //$sql7 = "DELETE FROM PAD_PESSOACONTATO WHERE CODIGOTIPOCONTATOITEM = 8 AND CODIGOPESSOA = $codigoPessoa";
		 //odbc_exec ($conexao, $sql7); 
	//INSERT NOVO CONTATO	 
		 $sql8 = "INSERT INTO PAD_PESSOACONTATO(CODIGOTIPOCONTATOITEM,CODIGOPESSOA,CONTATO,CODIGOAREA,CODIGOUSUARIO,CODIGOCONTATO,DATAATUALIZACAO) VALUES ('8',$codigoPessoa,'$cel1','$ddd1','$logl_cookie','$utreccon',GETDATE())";
		odbc_exec ($conexao, $sql8);
		$utreccon++;
	}
		
	//CEL 2	
	//INSERT NOVO CONTATO	
	if(($cel2 != "") && ($cel2 != $cel1)){
		 $sql9 = "INSERT INTO PAD_PESSOACONTATO(CODIGOTIPOCONTATOITEM,CODIGOPESSOA,CONTATO,CODIGOAREA,CODIGOUSUARIO,CODIGOCONTATO,DATAATUALIZACAO) VALUES ('8',$codigoPessoa,'$cel2','$ddd1','$logl_cookie','$utreccon',GETDATE())";
		 odbc_exec ($conexao, $sql9);
		 $utreccon++;
	}

	//RESIDENCIAL
	if($resi != ""){

	//DELETAR CONTATO ANTIGO
		 //$sql10 = "DELETE FROM PAD_PESSOACONTATO WHERE CODIGOTIPOCONTATOITEM = 7 AND CODIGOPESSOA = $codigoPessoa";
		 //odbc_exec ($conexao, $sql10); 
	//INSERT NOVO CONTATO	 
		 $sql11 = "INSERT INTO PAD_PESSOACONTATO(CODIGOTIPOCONTATOITEM,CODIGOPESSOA,CONTATO,CODIGOAREA,CODIGOUSUARIO,CODIGOCONTATO,DATAATUALIZACAO) VALUES (7,$codigoPessoa,'$resi','$ddd3','$logl_cookie','$utreccon',GETDATE())";
		 odbc_exec ($conexao, $sql11);
		 $utreccon++;
	}

	//E-MAIL
	if($email != ""){
	//DELETAR CONTATO ANTIGO
		 //$sql12 = "DELETE FROM PAD_PESSOACONTATO WHERE CODIGOTIPOCONTATOITEM = 6 AND CODIGOPESSOA = $codigoPessoa";
		 //odbc_exec ($conexao, $sql12); 
	//INSERT NOVO CONTATO		 
		 $sql13 = "INSERT INTO PAD_PESSOACONTATO(CODIGOTIPOCONTATOITEM,CODIGOPESSOA,CONTATO,CODIGOUSUARIO,CODIGOCONTATO,DATAATUALIZACAO) VALUES (6,$codigoPessoa,'$email','$logl_cookie','$utreccon',GETDATE())";
		 odbc_exec ($conexao, $sql13);
	} 

	//UPDATE DATE DE ATUALIZAÇÃO E AUTERA O CRITERIO DE ATUALIZAÇÃO
	$sqlud = "UPDATE PAD_PESSOA SET dateAtualizacao = GETDATE(), Atualizacao = 0 WHERE CODIGOPESSOA = $codigoPessoa";
	odbc_exec ($conexao, $sqlud);
	
	//ATUALIZA A TABELA DE ULTIMO REGISTRO
	$sql_padutr1 = "UPDATE PAD_ULTIMOREGISTRO SET ULTIMOREGISTRO = $utreccon WHERE NOMETABELA = 'PAD_PESSOACONTATO'";
	odbc_exec ($conexao, $sql_padutr1);
	*/
	
	/*
	//Contatos
	$ddd1		 = utf8_decode($_POST['ddd1']);
	$cel1		 = utf8_decode($_POST['ccel1']);
	$ddd2		 = utf8_decode($_POST['ddd2']);
	$cel2		 = utf8_decode($_POST['ccel2']);
	$ddd3		 = utf8_decode($_POST['ddd3']);
	$resi		 = utf8_decode($_POST['cres']);
	$email		 = utf8_decode($_POST['email']);
	
	//CELULAR 1
	if($cel1 != ""){
		$codigoContato = $date->getProximoRegistro("PAD_PESSOACONTATO");
		if(!($date->insertPessoaContato($codigoContato,8,$codigoPessoa,$cel1,$ddd1))){
			echo 'Erro ao salvar: '.$tResposta[1].'<br>';
		}
	}
	
	//CELULAR 2
	if(($cel2 != "") && ($cel2 != $cel1)){
		$codigoContato = $date->getProximoRegistro("PAD_PESSOACONTATO");
		if(!($date->insertPessoaContato($codigoContato,8,$codigoPessoa,$cel2,$ddd2))){
			echo 'Erro ao salvar: '.$tResposta[1].'<br>';
		}
	}

	//RESIDENCIAL
	if(($resi != "") && ($resi != $cel1) && ($resi != $cel2)){
		$codigoContato = $date->getProximoRegistro("PAD_PESSOACONTATO");
		if(!($date->insertPessoaContato($codigoContato,7,$codigoPessoa,$resi,$ddd3))){
			echo 'Erro ao salvar: '.$tResposta[1].'<br>';
		}
	}

	//E-MAIL
	if($email != ""){
		$codigoContato = $date->getProximoRegistro("PAD_PESSOACONTATO");
		if(!($date->insertPessoaContato($codigoContato,6,$codigoPessoa,$email))){
			echo 'Erro ao salvar: '.$tResposta[1].'<br>';
		}
	} 
	*/
	//Enquete
	if(isset($enquReposta) && $enquReposta != "" && $enquReposta != "NULL"){
		$litaResporta = explode("|",$enquReposta);
		foreach($litaResporta as $questaoResposta){			
			$tResposta		= explode("_", $questaoResposta);
			if($tResposta[2] < 4){
				$codigoResposta = $date->getProximoRegistro("ENQ_RESPOSTA");
				if(!($date->insertRespostaEnquete($codigoResposta,$codigoPessoa,$tResposta[1],$tResposta[0]))){
					echo 'Erro ao salvar: '.$tResposta[1].'<br>';
				}
			}else{
				$codigoResposta = $date->getProximoRegistro("ENQ_RESPOSTA");
				if(!($date->insertRespostaEnquete($codigoResposta,$codigoPessoa,$tResposta[1],"NULL",$tResposta[0]))){
					echo 'Erro ao salvar: '.$tResposta[1].'<br>';
				}
			}
		}
	}
	/*	
	if (isset($_POST['club']) && $_POST['club'] == 'true'){
		$pessoa = $date->getDadosPessoa();
		$iFidMax= $date->insertPessoaFidelimax($pessoa->CPFI,$pessoa->NOME,$pessoa->SEXO,$pessoa->EMAIL,$pessoa->DATANASCIMENTO,$pessoa->CELULAR);
		
		if($iFidMax->codResposta == 100){
			$date->insertLogFidelimax($pessoa->CPFI,'Consumidor Cadastrado');
		}else{
			$date->insertLogFidelimax($pessoa->CPFI,'Erro: '.$iFidMax->resposta);
		}
	}
	*/
	$date->setUpdate();
	echo 'Processo realizado com sucesso.';
	header('Location:../index.php5');
}else{
	header("Location:../index.php5");
}


?>