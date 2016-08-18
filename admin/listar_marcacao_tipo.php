<?php
require_once("inc_marcacao_tipo.php");

$ur = Util::paginaAtual($_REQUEST, "url,urlnoId");
$_SESSION["urlant"] = $ur ;
$_SESSION["array_querie_ant"] =  Util::paginaAtual($_REQUEST, "url,urlnoId",false);

$prefixo = "_p1";

$field_order_type = Util::request("field_order_type");
$field_order = Util::request("field_order");


?>
<?php Util::mensagemCadastro() ?>


<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>"
>

<input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
<input type="hidden" name="pag" value="<?php echo Util::request("pag") ?>" >
<input type="hidden" name="mod" value="<?php echo Util::request("mod") ?>" >

<!-- Filtro -->
<table style="display:none">
 

               
			<tr>
			    <td>
                     
        
			  <table>
				<tr>
				   <td><b>id</b></td>
			
				<td>Início: <input type="text"  name="id_inicio" value="<?=Util::numeroTela( Util::request("id_inicio"), true) ?>" onkeypress=" return SoNumero(event)"  
                      maxlength=""> </td>
					
				<td>Fim: <input type="text"  name="id_fim" value="<?=  Util::numeroTela( Util::request("id_fim"), true) ?>" 
				    onkeypress=" return SoNumero(event)" 
                      maxlength=""></td>
					</tr>	
				</table>
					 
					 
		      
				</td>
			
			</tr>
			
			 

               
			<tr>
			    <td>
                     
        
		 <b>nome</b><br>
         <input type="text"  name="nome" value="<?= Util::request("nome") ?>"   maxlength="">
        
		      
				</td>
			
			</tr>
			
			 

               
			<tr>
			    <td>
                     
        
		 <b>imagem</b><br>
         <input type="text"  name="imagem" value="<?= Util::request("imagem") ?>"   maxlength="">
        
		      
				</td>
			
			</tr>
			
			 

               
			<tr>
			    <td>
                     
        
		 <b>status</b><br>
         <input type="text"  name="status" value="<?= Util::request("status") ?>"   maxlength="">
        
		      
				</td>
			
			</tr>
			
			 

  <tr>
 <td align="left">
    Ordenar por: 
	<select name="field_order">
  
                        <option value="id" <? if ($field_order == "id"){ echo ( " selected "); } ?>>id</option>
		       
  
                        <option value="nome" <? if ($field_order == "nome"){ echo ( " selected "); } ?>>nome</option>
		       
  
                        <option value="imagem" <? if ($field_order == "imagem"){ echo ( " selected "); } ?>>imagem</option>
		       
  
                        <option value="status" <? if ($field_order == "status"){ echo ( " selected "); } ?>>status</option>
		       
	
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
    
    <div class="row">
        	<div class="col-xs-12">
          		<h1 class="sistem-title">Categorias de Marcação</h1>
            		<div class="form-inline">
            			<? if ( Util::request("exp_excel") == "" ) { ?>
            			<h4 class="sistem-subtitle">Filtrar por:</h4>
            			<input type="text" placeholder="Nome" class="form-control" name="txtfiltro" value="<?= Util::request("txtfiltro") ?>">
						<button type="button" class="btn btn-primary" class="botao" value="Pesquisar" onclick="document.frm.submit()">Buscar</button>
            			<? } ?>
            		</div>
			</div><!-- End Col 12 -->
		</div><!-- End Row -->
    

    <div class="row">
        			<div class="col-xs-3">
                		<h4 class="sistem-subtitle">Lista de Categorias de Marcação</h4>
              		</div>
              		<div class="col-xs-3 pull-right">
              		<? if ( Util::request("exp_excel") == "" ) { ?>
              			<ul class="sub-menu">
		                  <li class="sub-menu-item">
		                    <a href="#" onclick="openPagina('cad','<?= Util::request("pag") ?>','');" 
		                      class="action" data-toggle="tooltip" data-placement="left" title="Criar Novo">
		                      <span class="icon icon-file2 text-new"></span>
		                    </a>
		                  </li>
		                  <li class="sub-menu-item">
		                    <a href="" onclick="openPrint('listar','<?= Util::request("pag") ?>','','html');" 
		                    	class="action" data-toggle="tooltip" data-placement="bottom" title="Imprimir">
		                      <span class="icon icon-print text-print"></span>
		                    </a>
		                  </li>
		                  <li class="sub-menu-item">
		                    <a href="" onclick="openPrint('listar','<?= Util::request("pag") ?>','','');" 
		                    	class="action" data-toggle="tooltip" data-placement="right" title="Exportar Excel">
		                      <span class="icon icon-file-excel text-export"></span>
		                    </a>
		                  </li>
		                </ul>
		            <? } ?>
		            </div>
              		</div><!-- End Row -->
    
	
  <table width="95%" align="center" 

<? if ( Util::request("exp_excel") == "" ) { ?>
border="0" 
<? } else { ?>
	border="1" 
<? } ?>	

 cellspacing="1" cellpadding="4" class="table table-hover table-condensed">
         	<thead>
	 <tr height="20" >
	
     
			  
				<th  align="center" class="header">ID</th>
				
             

			  
				<th  align="center" class="header">Nome</th>
				<th  align="center" class="header">Imagem</th>
                                <th></th>
				
                 <!--

			  
				
             

			  
				<th  align="center" class="header">status</th>
				
                -->
              
	 </tr>
                </thead>
<?php

$prefixo = "p1_";

$filtro = "";

  
        
			   if ( Util::request("id_inicio") != "" ){
			  
			         $filtro .= " and p.id >= "  . Util::numeroBanco( Util::request("id_inicio") )." ";
			  }
			  if ( Util::request("id_fim") != "" ){
			  
			         $filtro .= " and p.id <= "  . Util::numeroBanco( Util::request("id_fim") )." ";
			  }
					 
					 
		       
  
		        if ( Util::request("nome") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("nome"))  );
			  
			         $filtro .= " and p.nome like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("imagem") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("imagem"))  );
			  
			         $filtro .= " and p.imagem like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("status") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("status"))  );
			  
			         $filtro .= " and p.status like '%".$strfilt."%' ";
			  }   
		       
		        if (Util::request("txtfiltro") != "" )
    					$filtro .= " and upper(nome) like upper('%".Util::request("nome")."%') ";

                        
                        $field_order = "nome";
						//$ordem = "descricao";

if ( $field_order != "" ){
	
       $filtro.= " order by "  . $field_order . " " .  $field_order_type;
}

$sql = " select * from marcacao_tipo p where 1 = 1 ". $filtro;


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
?>
                <tbody>
<?                    
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
	 

		 
		
			 <td align="left" class="td">&nbsp;<?=  Util::numeroTela( $item["id"], true);  ?></td> 
       
 
      
			 <td align="left" class="td">&nbsp;<?= $item["nome"] ?></td> 
       
 
      
			 <td align="left" class="td">&nbsp;<?= $item["imagem"] ?></td> 
       
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
         </tbody>
         
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
	///f.action = "cad_public.marcacao_tipo.php?acao=<?php echo Util::$LOAD?>&id="+id;
	f.action =  "index.php?pag=marcacao_tipo&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 
}

function excluir(id)
{
     if (! confirm("Deseja realmente excluir?. Isto ir&aacute; remover tamb&eacute;m todas as depend&ecirc;ncias deste registro."))
	     return; 
		
	var f = document.forms[0];
	f.action =  "delete.php?pag=marcacao_tipo&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 	
		
}

</script>