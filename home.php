<?php header("Content-Type: text/html; charset=utf-8",true); ?>
<html lang="pt-br">
<title>ATUALIZAÇÃO DE DADOS UNIFACEMA</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<link rel="stylesheet" type="text/css" href="js/jquery/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="js/jquery/themes/icon.css">
<link rel="stylesheet" type="text/css" href="js/jquery/demo/demo.css">
<script type="text/javascript" src="js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery.easyui.min.js"></script>
<style>
/*Formatação Geral*/
* {
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:8pt;
}

/* CABEÇALHO do SISTEMA */
#cabecalho
{
    background-image: url(imagens/cab.fundo.geral.repeat.png);
    background-repeat: repeat-x;
    color:#fff;
    height:60px;
	position:absolute;
	top:0%;
	left:0%;
    margin-bottom:10px;
	width:100%;
}
/* Cor do Texto no Cabeçalho */
#cabecalho *
{
    color:#fff;
}

/* Esquerda do Cabeçalho */
#logoCabecalho{
    background-image: url(imagens/cab.fundo.gera.esq.png);
    background-repeat:no-repeat;
    width: 650px;
    height:60px;
    font: Verdana;
    font-weight: bold;
    font-size:15px;
    vertical-align: middle;
    padding-left:65px;
    padding-top:10px;
}

/* Direita do Cabeçalho */
#logoSistema
{
    background-image: url(imagens/cab.fundo.geral.png);
    background-repeat: no-repeat;
    width: 312px;
    text-align: right;
    background-position: left top;
    height:60px;
    padding-right:10px;
    vertical-align: bottom;
	
}
#logo{
margin-left:200px;
}

#top{
margin-top:50px;
}

.window-shadow, .panel.window{
	top: 179px !important;
	left: 600px !important;;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#dlg').dialog('close');
 });

</script>
</head>
<body>

<div id="cabecalho"><div id="logoSistema"><div id="logoCabecalho"><div id="meioCabecalho"></div></div></div></div>
<div id="fundoLoginSelecionado"></div>
<div id="top">
<table style="margin-left:0px">
<tr><td width="30%">
<div id="logo">
<img src="imagens/login/login.empresa.png" style="position: absolute; top: 150px;">
</td>
<td width="0%" align="center"><img src="imagens/login/cab.fundo.geral.png" height="300" width="2" style="position: absolute; top: 145px;"></td>
</div>
<td width="60%">

<?php 

if ($date->getStatusEnvio() == 1 || isset($_POST['mt'])){
	include "fase2.php"; 	
}else{
	include "fase1.php";
}


?>
</td></tr>
</table>
</div>
</body>
</html>