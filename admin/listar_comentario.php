<?php
//require_once("inc_comentario.php");

$ur = Util::paginaAtual($_REQUEST, "url,urlnoId");
$_SESSION["urlant"] = $ur ;
$_SESSION["array_querie_ant"] =  Util::paginaAtual($_REQUEST, "url,urlnoId",false);

$prefixo = "_p1";

$field_order_type = Util::request("field_order_type");
$field_order = Util::request("field_order");


?>
<?php Util::mensagemCadastro() ?>


<form method="post" name="frm"
 action="index.php?pag=comentario&mod=<?php echo Util::request("mod") ?>">

<input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >

<!-- Filtro -->
<table>
                        <tr>
                            <td colspan="2">
                     
        
		 <b>Comentário</b>:
                 <input type="text"  name="comentario" value="<?= Util::request("comentario") ?>"   maxlength="300" style="width: 300px">
        
		      
				</td>
			
			</tr>
			
			 

  <tr>
 <td align="left">
    Ordenar por: 
	<select name="field_order">
  
                        <option value="id" <? if ($field_order == "id"){ echo ( " selected "); } ?>>id</option>
		       
  
                        <option value="comentario" <? if ($field_order == "comentario"){ echo ( " selected "); } ?>>comentario</option>
		       
  
                        <option value="nota" <? if ($field_order == "nota"){ echo ( " selected "); } ?>>nota</option>
		       
	
	</select>
	-  
	<select name="field_order_type">
	   <option value="asc" <? if ($field_order_type == "asc"){ echo ( " selected "); } ?>>Ascendente</option>
	   <option value="desc" <? if ($field_order_type == "desc"){ echo ( " selected "); } ?>>Descendente</option>	
	</select>
</td>
   <td  align="right">
    
	 
<input type="button" class="botao" value="Pesquisar" onclick="document.frm.submit()" />

   </td>

  </tr>

</table>

<div class="fieldBox">

<? if ( Util::request("exp_excel") == "" && false ) { ?>
	<table width="95%" cellspacing="0" cellpadding="0"  align="center" ><tr>

	<td  class="t-bold">Lista de registro(s) </td>

	<td  style="text-align: right; width: 90px">
	<a href="#" onclick="openPagina('cad','<?= Util::request("pag") ?>','');"><img width="20" height="20" src="images/add.png" title="Cadastrar"  /></a>
	&nbsp;&nbsp;&nbsp;
	<a href="#" onclick="openPrint('listar','<?= Util::request("pag") ?>','','html');"><img width="20" height="20" src="images/print.png" title="Imprimir" /></a>
	&nbsp;&nbsp;&nbsp;
	<a href="#" onclick="openPrint('listar','<?= Util::request("pag") ?>','','');"><img width="20" height="20" src="images/excel.png" title="Exportar para excel" /></a>
	
	</td>
	</tr></table>
<? } ?>
	
	
  <table width="95%" align="center" 

<? if ( Util::request("exp_excel") == "" ) { ?>
border="0" 
<? } else { ?>
	border="1" 
<? } ?>	

class="table table-hover table-condensed" cellspacing="1" cellpadding="4" >
      <thead>
	 <tr height="20" class="trheader">
		  
				<th  align="center" class="header">ID</th>
				
             

			  
				<th  align="center" class="header">Item do Mapa</th>
				
             

			  
				<th  align="center" class="header">Usuário</th>
				
             

			  
				<th  align="center" class="header">Comentário</th>
				
             
<? if ( Util::request("exp_excel") == "" ) { ?>
	<th  style="width: 40px">

	
	</th>
	
<? } ?>	
     
		

	 </tr>
      </thead>
<?php

$prefixo = "p1_";

$filtro = "";

  
		        if ( Util::request("id") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("id"))  );
			  
			         $filtro .= " and p.id like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("comentario") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("comentario"))  );
			  
			         $filtro .= " and p.comentario like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("nota") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("nota"))  );
			  
			         $filtro .= " and p.nota like '%".$strfilt."%' ";
			  }   
		       

if ( $field_order != "" ){
	
       $filtro.= " order by "  . $field_order . " " .  $field_order_type;
}

$sql = " select p.*, u.nome as nome_usuario, m.titulo as nome_marcacao from avaliacao_kappa p left join usuario "
        . "u on u.id = p.id_usuario left join marcacao m on m.id = p.id_registro  where 1 = 1 and p.nome_tabela='marcacao' ". $filtro;


$lista = connAccess::fetchData($oConn, $sql);

$inicio = 0;
$total = Util::NVL(count($lista),0);
//print(  $this->result);
$fim = 1;

//die (NVL(request("selQtdeRegistro"), constant("K_PAG_MINIMUN"))."------");
$tmp = SetaRsetPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"), constant("K_PAG_MINIMUN")),
		Util::NVL(Util::getParam($_REQUEST,$prefixo."selPagina"),1),$total,$inicio,$fim);

$z = 0 ;
$tarr = explode("_",$tmp);
$inicio = $tarr[0];
$fim = $tarr[1];

if ( Util::request("exp_excel") == "1" ) {
	$fim = count($lista);	
} 

for ($z =0; $z<= $fim ; $z++)
{
	if ($z >= $fim)
		break;
	
	if ($z < $inicio)
		continue;
	
	 $item  = $lista[$z];
	
	  $img = "edit.png";
	  $title = "Editar";
	
	  ?>
	 <tr height="20" class="<?php if ( $z%2){ echo "f-tabela-texto-alt"; } else { echo "f-tabela-texto";} ?>">
	 

		 
		
		
			 <td align="right" class="td">&nbsp;<?=   $item["id"] ;  ?></td> 
		
       
			 <td align="center" class="td">&nbsp;<?= $item["nome_marcacao"] ?></td> 
			 <td align="center" class="td">&nbsp;<?= $item["nome_usuario"] ?></td> 
 
      
			 <td align="center" class="td">&nbsp;<?= $item["ressalva"] ?></td> 
       
 
       	<td>
                                         <? if ( Util::request("exp_excel") == "" ) { ?>
                   				<a href="#" onclick="load('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
                      				<span class="icon icon-action icon-pencil text-warning"></span>
                    			</a>
			                    <a href="#"  onclick="excluir('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Excluir">
			                      <span class="icon icon-action icon-remove2 text-danger"></span>
			                    </a>
                  			<? } ?>
       
                  			</td>
	</tr>
     
     
	<?php 
	
	  } ?>
     
<?php 
if (Util::NVL(count($lista),0) == 0)
{
       	?>
       	 <tr height="20" bgcolor="#F2F2F2">
	  <td colspan="10" 
       	class="f-tabela-texto">
	    N&atilde;o h&aacute; dados a serem exibidos!</td>
	 </tr>
	<?php
}

     ?>
  </table>

<? if ( Util::request("exp_excel") == "" ) { ?>
<table style="width:95%;" align="center">
<input name="url" type="hidden" value="<?php 
     //echo Util::paginaAtual("url,urlnoId") ?>">
     
<?php 
MostrarPaginacao(Util::NVL( Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"),constant("K_PAG_MINIMUN")),
		Util::NVL(Util::getParam($_REQUEST, $prefixo."selPagina"),1),$total,"frm", true, true, $prefixo);
?>
</table>
<br>
<? } ?>

</div>

</form>
<script >
 function load(id)
 {
	var f = document.forms[0];
	///f.action = "cad_comentario.php?acao=<?php echo Util::$LOAD?>&id="+id;
	f.action =  "index.php?pag=comentario&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 
}

function excluir(id)
{
     if (! confirm("Deseja realmente excluir?. Isto ir&aacute; remover tamb&eacute;m todas as depend&ecirc;ncias deste registro."))
	     return; 
		
	var f = document.forms[0];
	f.action =  "<?=K_RAIZ?>delete.php?pag=comentario&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 	
		
}

</script>