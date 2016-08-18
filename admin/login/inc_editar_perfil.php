<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?

    $acao = Util::request("acao");
    $msg = "";
     if ( $acao == "editar"){
         
         Usuario::EditPerfil($id_usuario_logado);
         $msg = "Dados de perfil editados com sucesso!";
     }
 

    $registro =  Usuario::getUser( $id_usuario_logado );
    
    
    
?>
    <?if ( $msg != ""){ ?>
    <div class="mensagem_aviso"><?=$msg?></div>
    <? } ?>
<div class="titulo_pagina">Editar Perfil</div>

	<form  method="post" name="form_editar_perfil">


	<!-- Obrigatório -->
	<div id="box_conteudo">
    	<div class="titulo_bloco_conteudo">Obrigatório</div>
        <div class="titulo_required">Estes dados não são compartilhados com outros usuários, <a href="">Saiba mais.</a></div>
            <div id="formulario">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label>Nome</label></td>
                <td><input type="text" name="nome" maxlength="300" value="<?= $registro["nome"] ?>"/></td>
              </tr>
              <tr>
                <td><label>Sobrenome</label></td>
                <td><input type="text" name="sobrenome" maxlength="300" value="<?= $registro["sobrenome"] ?>"/></td>
              </tr>
              <tr>
                <td><label class="required">Auto definição de Gênero</label></td>
                <td><input type="text" name="genero" maxlength="300" value="<?= $registro["genero"] ?>"/></td>
              </tr>
            </table>
            
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
              <?
               $ano = "";
               $mes = "";
               $dia = "";
               
               if ( $registro["data_nascimento"] != "" ){
                   
                   $dt = new DateTime( $registro["data_nascimento"] );
                          
                   $ano = $dt->format("Y");
                   $mes = $dt->format("m");
                   $dia = $dt->format("d");
                   
               }
              
              
              ?>
                  
                <td><label class="required">Data de Nascimento</label></td>
                <td><select class="data" name="mes">
                <option value="">Mês</option>
                <?php
                  for ($i = 1; $i <=12 ; $i++){
                      
                      Util::populaCombo(str_pad($i,2,"0",STR_PAD_LEFT),  Util::mes_nome($i), $mes );
                  }
                ?>
                
                </select></td>
                <td><select class="data" name="dia">
                <option value="">Dia</option>
                 <?php
                  for ($i = 1; $i <=31 ; $i++){
                      
                      Util::populaCombo(str_pad($i,2,"0",STR_PAD_LEFT), str_pad($i,2,"0",STR_PAD_LEFT), $dia );
                  }
                ?>
                </select></td>
                <td> <select class="data" name="ano">
                             <option value="">Ano</option>
                 <?php
                  
                  $atual = date("Y");
                  $inicio = $atual - 110;
                  $fim = $atual - 10;
                  for ($i = $inicio; $i <=$fim ; $i++){
                      
                      Util::populaCombo($i,  $i, $ano );
                  }
                ?>
                </select></td>
              </tr>
            </table>

            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label class="required">E-mail</label></td>
                <td><input type="text" name="email" maxlength="300" value="<?= $registro["email"] ?>"/></td>
              </tr>
            </table>
            
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label class="required">CPF</label></td>
                <td><input type="text" class="cpf"  name="cpf" maxlength="15" value="<?= $registro["cpf"] ?>"/></td>
                <td><label class="rg required">RG</label></td>
                <td><input  type="text" class="rg" name="rg" maxlength="15" value="<?= $registro["rg"] ?>"/></td>
              </tr>
              <tr>
                <td><label class="required">Telefone</label></td>
                <td><input type="text" class="telefone" name="telefone" maxlength="15" value="<?= $registro["telefone"] ?>"/></td>
                <td><label class="celular required">Celular</label></td>
                <td><input  type="text" class="celular" name="telefone2" maxlength="15" value="<?= $registro["telefone2"] ?>"/></td>
              </tr>
            </table>
            
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label class="required">Endereço</label></td>
                <td><input type="text" name="endereco" maxlength="300" value="<?= $registro["endereco"] ?>"/></td>
              </tr>
            </table>

            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label class="required">Cidade</label></td>
                <td><input type="text" class="cidade" name="municipio" maxlength="300" value="<?= $registro["municipio"] ?>"/></td>
                <td><label class="estado required">Estado</label></td>
                <td><select class="estado">
                <option></option>
                
                <?php
                  
                $lista = connAccess::fastQuerie($oConn, "geral.tb_estados",""," uf asc ");
                
               
                Util::CarregaComboArray ($lista, "uf","uf", $registro["uf"]);
                
                ?>
                
                <option>AC</option>
                <option>AL</option>
                <option>AM</option>
                </select></td>
                <td><label class="pais required">País</label></td>
                <td><input type="text" class="pais"  name="pais" maxlength="50" value="<?= Util::NVL( $registro["pais"],"Brasil") ?>"/></td>
              </tr>
            </table>
            
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label class="required">Bairro</label></td>
                <td><input type="text" class="bairro" name="bairro" maxlength="150" value="<?=  $registro["bairro"] ?>"/></td>
                <td><label class="cep required">CEP</label></td>
                <td><input name="Nome" type="text" class="cep" name="cep" maxlength="8" value="<?=  $registro["cep"] ?>"/></td>
              </tr>
            </table>
            
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label class="required">Descreva-se</label></td>
                <td><textarea name="auto_descricao" cols="1" rows="1"><?=  $registro["auto_descricao"] ?></textarea></td>
              </tr>
            </table>      
            </div>   
	</div>
    
    
    
    <!-- Opcional -->
    <div id="box_conteudo">
    	<div class="titulo_bloco_conteudo">Opcional</div>  
            <div id="formulario">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label>Educação Formal ou Informal</label></td>
                <td><input type="text" name="edtr_educacao" maxlength="300" value="<?=  $registro["edtr_educacao"] ?>"/></td>
              </tr>
              <tr>
                <td><label>Profissão</label></td>
                <td><input type="text" name="edtr_profissao" maxlength="300" value="<?=  $registro["edtr_profissao"] ?>"/></td>
              </tr>
              <tr>
                <td><label>Empresa que Trabalha</label></td>
                <td><input type="text" name="edtr_empresa" maxlength="300" value="<?=  $registro["edtr_empresa"] ?>"/></td>
              </tr>
            </table>
            
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
              <?
              $lista_fuso = array();
              
              for ( $y = -12; $y <= 12; $y++){
                  
                  $indicativo = $y;
                  
                  if ( $y == 0)
                      $indicativo = "";
                  
                  if ( $y> 0 )
                      $indicativo = "+".$y;
                  
                  $lista_fuso[ count($lista_fuso)] = array("id"=>$y, "nome"=>"UTC". $indicativo );
              }
              
              
              ?>                 
                  
                <td><label>Fuso horário</label></td>
                <td><select class="fuso_horario" name="fuso_horario">
                <option></option>
                <?
                
                
                 Util::CarregaComboArray($lista_fuso, "id","nome", Util::NVL($registro["fuso_horario"],"-3") );
                ?>
                </select></td>
                <td><label class="contato_seguranca">Contato de Segurança</label></td>
                <td><input type="text" class="contato_seguranca" maxlength="300" value="<?=  $registro["contato_seguranca"] ?>"/></td>
              </tr>
            </table>      
            </div>  
	</div>
    
    
     <? if ( $registro["id"] != ""){ ?>
    <!-- Manifesto Pessoal -->
    <div id="box_conteudo">
    	<div class="titulo_bloco_conteudo">Manifesto Pessoal</div> 
            <div class="icones_manifesto_pessoal" >
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td><a class="bt" href="painel_controle.php?pag=inc_editar_perfil_imagem"><img src="../painel/images/icon_perfil_foto.png"/></a></td>
                <td><a class="bt" href="painel_controle.php?pag=inc_editar_perfil_dado&tipo=video"><img src="../painel/images/icon_perfil_video.png"/></a></td>
                <td><a class="bt" href="painel_controle.php?pag=inc_editar_perfil_dado&tipo=audio"><img src="../painel/images/icon_perfil_audio.png"/></a></td>
                <td><a class="bt" href="painel_controle.php?pag=inc_editar_perfil_dado&tipo=texto"><img src="../painel/images/icon_perfil_texto.png"/></a></td>
              </tr>
            </table>
            </div>
	</div>
     <? } ?>
       
    
    <!-- Alterar / Criar Senha -->
    <div id="box_conteudo">
    	<div class="titulo_bloco_conteudo">Alterar / Criar Senha</div>  
            <div id="formulario">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><label>Nova Senha</label></td>
                <td><input type="password" class="nova_senha"  name="senha" maxlength="30" value=""  autocomplete="off"/></td>
                <td><label class="confirmar_senha">Confirmar Senha</label></td>
                <td><input type="password" class="confirmar_senha"  name="confirmar_senha"  maxlength="30" value="" autocomplete="off"/></td>
              </tr>
            </table>      
            </div>  
	</div>
    
    
    <? if ( $registro["id"] != ""){ ?>
    <!-- Salvar -->
    <input class="bt_salvar button" name="btSalvar" onclick="fn_salvar();" type="button" value="Salvar" />
    <? } else { ?>
    <i>Usuário não logado</i> <br><Br>
    <? } ?>
            <input type="hidden" name="acao" value="">
            <input type="hidden" name="pag" value="<?= Util::request("pag") ?>">
    </form>
<script src="../javascript/validacampos.js" ></script>
<script type="text/javascript">
function fn_salvar(){
    
    var f = document.forms[0];
    
  
        if ( isVazio(f.nome, "Informe seu nome!"))
            return false;

        if ( isVazio(f.sobrenome, "Informe seu sobrenome!"))
            return false ;
    
      
        if ( f.ano.value != "" || f.mes.value != "" || f.dia.value != ""){

                    if ( f.ano.value != "" && f.mes.value != "" && f.dia.value != ""){

                        if ( ! eData( f.dia.value +"/"+f.mes.value+"/"+f.ano.value ) ){
                            
                            alert(" A data de nascimento " + f.dia.value +"/"+f.mes.value+"/"+f.ano.value + " e inválida!. Por favor informe a data correta." );
                            f.dia.focus();
                            return false;
                        }
                    }else{
                        
                            alert("É necessário preencher o Mês/Dia/Ano da data de nascimento!");
                            if ( f.dia.value == ""){
                                
                                f.dia.focus();
                                return;
                            }else if ( f.mes.value == ""){
                                f.mes.focus();
                                return;
                            }else if ( f.ano.value == ""){
                                f.ano.focus();
                                return;                               
                            }
                            
                        
                        
                    }
         }
         
         if ( f.senha.value != "" ){
             
                     if ( isVazio(f.confirmar_senha, "Confirme sua nova senha!"))
                         return false ;
    
    
                     if ( f.senha.value != f.confirmar_senha.value ){
                         
                         alert("Atenção!. Senha e confirmação não são iguais!");
                         return false;
                     }
             
         }
         
         f.acao.value="editar";
         f.submit();
}



</script>

</body>
</html>