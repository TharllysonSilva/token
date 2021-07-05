 <?php
	header('Content-Type: text/html; charset=utf-8');
 ?>
 <title> ATUALIZAÇÃO DE DADOS UNIFACEMA </title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="js/jquery-3.5.1.slim.min.js" ></script>
    <script src="bootstrap/js/bootstrap.min.js" ></script>
    <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>

    <style>

        body, html {
			   background-image: url("img/fundo.png");
            height: 100%;
            color: #fff;
			            background-repeat: no-repeat;
            background-size: cover;
			background-attachment: fixed;
			 
        }
        .fundo{
         
            height: 100%;
            background-position: center;

        }

        .align-items-center{
            display: flex;
            align-items: center;
        }
        .fundo_trans{
            background-image: url("img/trans_preto.png");
        } 
        .caixa {
            border: 2px solid #fff;
        }
        .label{ color: #fff !important;}

    </style>

<script type="text/javascript">

function findCEP() {
    if($.trim($("#zipcode").val()) != ""){
        $("#ajax-loading").css('display','inline');
        $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#zipcode").val().replace("-", ""), function(){
            if(resultadoCEP["resultado"] == 1){
                $("#street").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
                document.getElementById('street').readOnly = true;
                $("#district").val(unescape(resultadoCEP["bairro"]));
                document.getElementById('district').readOnly = true;
                $("#city").val(unescape(resultadoCEP["cidade"]));
                document.getElementById('city').readOnly = true;
                $("#state").val(unescape(resultadoCEP["uf"]));
                document.getElementById('state').readOnly = true;
                $("#number").focus();
            }else{
                alert("Endereço não encontrado para o cep ");
            }
            $("#ajax-loading").hide();
        });
    }
}
$(document).ready(function(){
		
    $("#bt-salvar").click(function(){
        //event.preventDefault();
        
        /*Enquere*/
        var enquete		= $('#ids').val().split("|");
        var resposta	= null;
        $.each(enquete,function(id,valor) {
            if(valor != "" || valor != null){
                qqestao	 = valor.split("_");
                
                if(qqestao[2] > 2){
                    if($.trim($("#"+valor).val()) != "" && $.trim($("#"+valor).val()) != null && $.trim($("#"+valor).val()) != "null"){
                        if(resposta == null){
                            resposta = $("#"+valor).val()+'_'+qqestao[0]+'_'+qqestao[2];
                        }else{
                            resposta += '|'+$("#"+valor).val()+'_'+qqestao[0]+'_'+qqestao[2];
                        }
                    }
                }else{
                    for (i = 1; i <= qqestao[3]; i++) {
                        var ident = qqestao[0]+'_'+qqestao[1]+'_'+qqestao[2]+'_'+i;
                        if($("#"+ident).is(':checked')){
                            if(resposta == null){
                                resposta = $("#"+ident).val()+'_'+qqestao[0]+'_'+qqestao[2];
                            }else{
                                resposta += '|'+$("#"+ident).val()+'_'+qqestao[0]+'_'+qqestao[2];
                            }
                        }
                    }
                    
                }
            }
        });	
        //console.log(resposta);
        $('#enquReposta').val(resposta);
    });
    
	/*
	$("#788_7_1_1").click(function(){
		$(".qst8").removeClass('d-none');
		$(".qst9").removeClass('d-none');
		$(".qst10").removeClass('d-none');
		$(".qst11").removeClass('d-none');
		$(".qst12").removeClass('d-none');
		$(".qst13").removeClass('d-none');
		$(".qst14").removeClass('d-none');
		$(".qst15").removeClass('d-none');
		$(".qst16").removeClass('d-none');
		$(".qst17").removeClass('d-none');
		$(".qst18").removeClass('d-none');
		$(".qst19").addClass('d-none');
		
		$('.qst8 input').attr('required', true);
		$('.qst9 input').attr('required', true);
		$('.qst10 input').attr('required', true);
		$('.qst11 input').attr('required', true);
		$('.qst12 input').attr('required', true);
		$('.qst13 input').attr('required', true);
		$('.qst14 input').attr('required', true);
		$('.qst15 input').attr('required', true);
		$('.qst16 input').attr('required', true);
		$('.qst17 input').attr('required', true);
		$('.qst18 input').attr('required', true);
		$('.qst19 input').attr('required', false);
	});
	$("#788_7_1_2").click(function(){
		$(".qst8").addClass('d-none');
		$(".qst9").addClass('d-none');
		$(".qst10").removeClass('d-none');
		$(".qst11").removeClass('d-none');
		$(".qst12").removeClass('d-none');
		$(".qst13").addClass('d-none');
		$(".qst14").addClass('d-none');
		$(".qst16").addClass('d-none');
		$(".qst17").addClass('d-none');
		$(".qst18").addClass('d-none');
		$(".qst15").removeClass('d-none');
		$(".qst19").removeClass('d-none');
		
		$('.qst8 input').attr('required', false);
		$('.qst9 input').attr('required', false);
		$('.qst10 input').attr('required', true);
		$('.qst11 input').attr('required', true);
		$('.qst12 input').attr('required', true);
		$('.qst13 input').attr('required', false);
		$('.qst14 input').attr('required', false);
		$('.qst15 input').attr('required', true);
		$('.qst16 input').attr('required', false);
		$('.qst17 input').attr('required', false);
		$('.qst18 input').attr('required', false);
		$('.qst19 input').attr('required', true);
	});
	*/
	//$(".mskCell").mask("(99) 99999-9999");
});


function addnove(){
    $pre = document.form;
    if($pre.ddd1.value == 91 || $pre.ddd1.value == 92 || $pre.ddd1.value == 93 || $pre.ddd1.value == 94 || $pre.ddd1.value == 95 || $pre.ddd1.value == 96 || $pre.ddd1.value == 97 || $pre.ddd1.value == 98 || $pre.ddd1.value == 99 || $pre.ddd1.value == 81 || $pre.ddd1.value == 82 || $pre.ddd1.value == 83 || $pre.ddd1.value == 84 || $pre.ddd1.value == 85 || $pre.ddd1.value == 86 || $pre.ddd1.value == 87 || $pre.ddd1.value == 88 || $pre.ddd1.value == 89 || $pre.ddd1.value == 71 || $pre.ddd1.value == 72 || $pre.ddd1.value == 73 || $pre.ddd1.value == 74 || $pre.ddd1.value == 75 || $pre.ddd1.value == 76 || $pre.ddd1.value == 77 || $pre.ddd1.value == 78 || $pre.ddd1.value == 79 || $pre.ddd1.value == 31 || $pre.ddd1.value == 32 || $pre.ddd1.value == 33 || $pre.ddd1.value == 34 || $pre.ddd1.value == 35 || $pre.ddd1.value == 36 || $pre.ddd1.value == 37 || $pre.ddd1.value == 38 || $pre.ddd1.value == 39){
    $pre.ccel1.value = 8
        }
    };
function regemail(){
    email = document.getElementById("email").value;
    er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/; 
    if( !er.exec(email)){
        document.getElementById('email').value='';
        alert("E-mail invalido");
        document.getElementById('email').required = false;
    }};
function required(){
    if(document.getElementById('ddd3').value !=''){
    document.getElementById('cres').required = true;}
}
</script>

<script language='JavaScript'>
function SomenteNumero(e){
	var tecla=(window.event)?event.keyCode:e.which;
	if((tecla>47 && tecla<58)) return true;
	else{
		if (tecla==8 || tecla==0) return true;
		else return false;
	}
}

</script>

<?php
	
	$dadosPessoa = @$date->getDadosPessoa();
    $dadosEnquete  = @$date->getDadosEnquete(@$codigoEnquete);

?>

</head>
<body>
    <div class="fundo ">
         <div class="container-fluid ">
             <div class="row d-flex justify-content-center">
                 <div class="col-md-12">
					 <div class="row  align-items-center ">
						<div class="col-md-4 mx-auto text-center">
							<img src="img/UNIFACEMA-MARCA.png" class="img-fluid  center-block mt-4" style="max-width: 250px;" alt=""><br/><br/>
						</div>
					 </div>
                 </div>
                 <div class="col-md-10">

                    <div class="fundo_trans h-100  p-5 pt-4"><!--<h2 class="text-center text-light">ATUALIZAÇÃO DE <br> DADOS UNIFACEMA</h2>-->
<form action = "" method ="post" id="form" name="form">   

<div class="caixa p-4">


<input type="hidden" id="resp_enquete" name="resp_enquete" value= "" />

    <div class="row">
        <div class="col-md-4">

            <div class="form-group">
                <label for="mt">Matrícula</label>
                <input type="text" class="form-control"  id="mt" name="mt" disabled="disabled" readonly  value="<?php echo $dadosPessoa->LOGINPESSOA; ?>">
            </div>

        </div>
        <div class="col-md-8">

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" readonly aria-describedby="" value="<?php echo @$dadosPessoa->NOME; ?>">
            </div>


        </div>
        <div class="col-12">
            <h4>Dados para contato</h4>
        </div>
        <div class="col-md-6">

            <div class="form-group">
                <label for="email">E-mail <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="email" name="email" aria-describedby=""  onchange="regemail()" oninvalid="setCustomValidity('Informe um e-mail valido')" placeholder="email@email.com"  required="required">
            </div>

        </div>

        <div class="col-md-6">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email">Contato <span class="text-danger">*</span></label>
                    <div class="form-row">
                        <div class="col-4">
                            <input type="text" class="form-control" id="ddd1" name="ddd1" placeholder="DDD"  required="required" MAXLENGTH="2"  onkeypress='return SomenteNumero(event)' pattern="[0-9]{2}" oninvalid="setCustomValidity('Informe um DDD válido')" >
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="ccel1" name="ccel1" required="required" MAXLENGTH="9" onkeypress='return SomenteNumero(event)' pattern="[0-9]{8,9}" MAXLENGTH="9" oninvalid="setCustomValidity('Informe um número válido')" placeholder="Numero de contato">
                        </div>
                       
                    </div>


                </div>
            </div>
        </div>

        </div>

        <!--<div class="col-md-6">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email">Celular 2</label>
                    <div class="form-row">
                        <div class="col-4">
                            <input type="text" class="form-control"  id="ddd2" name="ddd2"  placeholder="DDD" MAXLENGTH="2" onkeypress='return SomenteNumero(event)' pattern="[0-9]{2}" oninvalid="setCustomValidity('Informe um DDD válido')" title="Informe um DDD válido">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="ccel2" name="ccel2"  onkeypress='return SomenteNumero(event)' pattern="[0-9]{8,9}" MAXLENGTH="9" oninvalid="setCustomValidity('Informe um número válido')" title="Informe um número válido" placeholder="Numero de contato">
                        </div>
                    
                    </div>


                </div>
            </div>
        </div>

        </div>-->

        <!--<div class="col-md-6">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email">Telefone Residencial</label>
                    <div class="form-row">
                        <div class="col-4">
                            <input type="text" class="form-control" id="ddd3" name="ddd3" MAXLENGTH="2" onkeypress='return SomenteNumero(event)' pattern="[0-9]{2}" oninvalid="setCustomValidity('Informe um DDD válido')" title="Informe um DDD válido" onchange="required()" placeholder="DDD" >
                        </div>
                        <div class="col">
                            <input type="text" id="cres" name="cres" class="form-control"  onkeypress='return SomenteNumero(event)' pattern="[0-9]{8}" maxlength="8" oninvalid="setCustomValidity('Informe um número válido')" title="Informe um número válido" placeholder="Numero de contato">
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>

        </div>-->

    </div>

</div> <? // final da caixa ?>


<span class="style4">Obs:</span> <span class="style1">Todos os campos seguidos com asterisco em vermelho são obrigatorios.</span>

<div class="caixa p-4 mt-4">




<p class="text-center h3 style2"><strong><?php echo utf8_encode($dadosEnquete->titulo); ?></strong></p>
<input type="hidden" id="enquReposta" name="enquReposta" value="">
<p class="text-center style2"><?php echo utf8_encode($dadosEnquete->subtitulo); ?><p/>

	<!--<div ><span class="icon icon-edu"></span><h2>Questionario Socioeconômico</h2></div>-->
	<?php
		$qstEnquete	= $date->getQuestaoEnquete($codigoEnquete);
		$idQ 		= NULL;
		foreach($qstEnquete as $quetao){
			if($quetao->NUMEROQUESTAO < 8 or 1 == 1){echo '<div class="form-group">';}else{echo '<div class="form-group d-none qst'.$quetao->NUMEROQUESTAO.'">';}
			echo '<label for="">'.$quetao->NUMEROQUESTAO.'. '.trim(utf8_encode($quetao->DESCRICAOQUESTAO));
			if($quetao->RESPOSTAOBRIGATORIA == 1){
				echo '<span class="text-danger"> *</span></label><br/>';
			}else{
				echo '</label><br/>';
			}
			
			$qstAlternativa = $date->getAlternativaEnquete($quetao->CODIGOQUESTAO);
			
			$idr = $quetao->CODIGOQUESTAO.'_'.$quetao->NUMEROQUESTAO.'_'.$quetao->CODIGOTIPOQUESTAO;
			
			if($quetao->CODIGOTIPOQUESTAO == 1){			
				$indice  = 1;
				foreach($qstAlternativa as $alternativas){
					if($quetao->RESPOSTAOBRIGATORIA == 1){
						echo '<input type="radio" name="'.$idr.'" id="'.$idr.'_'.$indice.'" value="'.$alternativas->CODIGOALTERNATIVA.'" required> '.utf8_encode($alternativas->DESCRICAOALTERNATIVA).'<br>';
					}else{
						echo '<input type="radio" name="'.$idr.'" id="'.$idr.'_'.$indice.'" value="'.$alternativas->CODIGOALTERNATIVA.'" > '.utf8_encode($alternativas->DESCRICAOALTERNATIVA).'<br>';
					}
					
					$indice += 1;
				}
				if($idQ == NULL){$idQ = $idr.'_'.$indice;}else{$idQ .= '|'.$idr.'_'.$indice;}
			}
			
			if($quetao->CODIGOTIPOQUESTAO == 2){
				$indice = 1;
				$required= true;
				foreach($qstAlternativa as $alternativas){
					if($required && $quetao->RESPOSTAOBRIGATORIA == 1){
						echo '<input type="checkBox" name="'.$idr.'" id="'.$idr.'_'.$indice.'" value="'.$alternativas->CODIGOALTERNATIVA.'"> '.utf8_encode($alternativas->DESCRICAOALTERNATIVA).'<br>';
						$required = false;
					}else{
						echo '<input type="checkBox" name="'.$idr.'" id="'.$idr.'_'.$indice.'" value="'.$alternativas->CODIGOALTERNATIVA.'"> '.utf8_encode($alternativas->DESCRICAOALTERNATIVA).'<br>';
					}
					$indice += 1;
				}
				if($idQ == NULL){$idQ = $idr.'_'.$indice;}else{$idQ .= '|'.$idr.'_'.$indice;}
			}
				
			if($quetao->CODIGOTIPOQUESTAO == 3){
				if($idQ == NULL){$idQ = $idr;}else{$idQ .= '|'.$idr;}
				if($quetao->RESPOSTAOBRIGATORIA == 1){
					$opcao = '<select class="form-control" id="'.$idr.'" name="'.$idr.'" style="width: 50%;" required><option value="null" selected disabled>-- Selecione --</option>';
				}else{
					$opcao = '<select class="form-control" id="'.$idr.'" name="'.$idr.'" style="width: 50%;" ><option value="null" selected disabled>-- Selecione --</option>';
				}
				foreach($qstAlternativa as $alternativas){
					$opcao .= '<option value="'.$alternativas->CODIGOALTERNATIVA.'">'.utf8_encode($alternativas->DESCRICAOALTERNATIVA).'</option>';
				}
				$opcao .= '</select><br/><br/>';
				echo $opcao;
			}
			if($quetao->CODIGOTIPOQUESTAO == 4){
				if($idQ == NULL){$idQ = $idr;}else{$idQ .= '|'.$idr;}
				if($quetao->RESPOSTAOBRIGATORIA == 1){
					echo '<textarea class="form-control" rows="5" id="'.$idr.'" style="width: 100%;" required></textarea><br/><br/>';
				}else{
					echo '<textarea class="form-control" rows="5" id="'.$idr.'" style="width: 100%;" ></textarea><br/><br/>';
				}
			}
			if($quetao->CODIGOTIPOQUESTAO == 5){
				if($idQ == NULL){$idQ = $idr;}else{$idQ .= '|'.$idr;}
				$ops = 'maxlength="100"';
				$cls = 'form-control';
				$tpy = 'text';
				
				if($quetao->NUMEROQUESTAO == '3'){
					$ops = 'onkeypress=\'return SomenteNumero(event)\' minlength="8" MAXLENGTH="11" oninvalid="setCustomValidity(\'Informe um número válido\')" title="Informe um número válido" placeholder="Ex.: (00) 00000-0000"';
					$cls = 'form-control';
					$tpy = 'text';
				}
				
				if($quetao->NUMEROQUESTAO == '4'){
					$tpy = 'email';
				}
				
				if($quetao->RESPOSTAOBRIGATORIA == 1){
					echo '<input class="'.$cls.'" type="'.$tpy.'" name="'.$idr.'" id="'.$idr.'" value="" '.$ops.' required>';
				}else{
					echo '<input class="'.$cls.'" type="'.$tpy.'" name="'.$idr.'" id="'.$idr.'" value="" '.$ops.'>';
				}
			}
			echo '<br/></div>';
		}
	echo '<input type="hidden" id="ids" value="'.$idQ.'">';
	?>

<!--
<div class="form-check">
	<input type="checkbox" class="form-check-input" id="club" name="club" value="true">
	<label class="form-check-label" for="exampleCheck1">Aceitar participar do club+ Unifacema, você concorda com os nossos <a target="_blank" href="https://portal.facema.edu.br/club-unifacema/politica">Termos de uso e Política de Privacidade</a>  </label>
</div>
-->

  <br>

<input name="Submit" type="submit" class="btn btn-primary btn-lg btn-block" id="bt-salvar" value="Salvar">


</div>


</form>

                        

                    </div>

                 </div>
             </div>
         </div>
    </div>

 