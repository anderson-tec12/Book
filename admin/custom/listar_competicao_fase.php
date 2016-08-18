<?php
 //Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro
require_once("inc_competicao_fase.php");
require_once("custom/inc_ferramenta.php");

$ur = Util::paginaAtual($_REQUEST, "url,urlnoId");
$_SESSION["urlant"] = $ur ;
$_SESSION["array_querie_ant"] =  Util::paginaAtual($_REQUEST, "url,urlnoId",false);

$prefixo = "_p1";

$field_order_type = Util::request("field_order_type");
$field_order = Util::NVL(Util::request("field_order"),"codigo");


?>
<?php Util::mensagemCadastro() ?>

<form method="post" name="frm"
 action="index.php?pag=competicao_fase&mod=<?php echo Util::request("mod") ?>">

<input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
<input type="hidden" name="mn" value="<?php echo Util::request("mn") ?>" >
<!-- Filtro -->

<div class="fieldBox">

   	<? if ( Util::request("exp_excel") == "" ) { ?>
	<div class="row">
    <div class="col-xs-12">
	<h1 class="sistem-title">Fases da Competição</h1>
     <div class="form-inline">
	 <h4 class="sistem-subtitle">Filtrar por:</h4>
                 
                     
		 <label class="sr-only" for="titulo">Título</label>
         <input type="text" placeholder="Título" name="titulo" id="titulo" class="form-control" value="<?= Util::request("titulo") ?>"   maxlength="300">
    
		      
				

                     
		 <label class="sr-only" for="codigo">Código</label>
         <input type="text" placeholder="Código" name="codigo" id="codigo" class="form-control" value="<?= Util::request("codigo") ?>"   maxlength="">
    
		      
				

                     
					 <? 
					 $rslista = connAccess::fetchData($oConn, "select id, titulo from modulo order by titulo"); 
					 ?>
					 <label class="sr-only" for="modulos">Módulos Associados</label>
					 <select class="form-control"  name="modulos" id="modulos"> 
							<option value="">-Selecione um módulo-</option>
					   <? 
					   Util::CarregaComboArray( $rslista, "titulo" , "titulo",  Util::request("modulos") ); ?>  
					 </select> 
					
		      
				

                     
					 <? 
					 $rslista = connAccess::fetchData($oConn, "select id, titulo from ferramenta order by titulo"); 
					 ?>
					 <label class="sr-only" for="ferramentas">Ferramentas</label>
					 <select class="form-control"  name="ferramentas" id="ferramentas"> 
							<option value="">-Selecione uma Ferramenta-</option>
					   <? 
					   Util::CarregaComboArray( $rslista, "titulo" , "titulo",  Util::request("ferramentas") ); ?>  
					 </select> 
					
		      
				


				 <div class="row">
						<div class="col-xs-12">
							<h4 class="sistem-subtitle">Ordenar por:</h4>
			        			<label class="sr-only" for="field_order">Ordenar por</label>
				                <select name="field_order" class="form-control">
								  
                        <option value="id" <? if ($field_order == "id"){ echo ( " selected "); } ?>>ID</option>
		       
  
                        <option value="titulo" <? if ($field_order == "titulo"){ echo ( " selected "); } ?>>Título</option>
		       
  
                        <option value="codigo" <? if ($field_order == "codigo"){ echo ( " selected "); } ?>>Código</option>
		       
  
                        <option value="texto" <? if ($field_order == "texto"){ echo ( " selected "); } ?>>Texto</option>
		       
  
                        <option value="modulos" <? if ($field_order == "modulos"){ echo ( " selected "); } ?>>Módulos Associados</option>
		       
  
                        <option value="ferramentas" <? if ($field_order == "ferramentas"){ echo ( " selected "); } ?>>Ferramentas</option>
		       
									
									</select>
							<label class="sr-only" for="field_order_type">Ordenar por</label>
								<select name="field_order_type" class="form-control">
								   <option value="asc" <? if ($field_order_type == "asc"){ echo ( " selected "); } ?>>Ascendente</option>
								   <option value="desc" <? if ($field_order_type == "desc"){ echo ( " selected "); } ?>>Descendente</option>	
								</select>
								<input type="button" class="btn btn-primary" class="botao" value="Pesquisar" value="Buscar" onclick="document.frm.submit()">
                            </div>
				</div>			
          </div><!-- End Form Filter-->
        </div><!-- End col 12 -->
    </div><!-- End Row -->
  <? } ?>
  
    <div class="row">
        <div class="col-xs-12">
          <div class="bs-example">
          	<div class="row">
			
              	<? if ( Util::request("exp_excel") == "" ) { ?>
				<div class="col-xs-3">
                <h4 class="sistem-subtitle">Lista de Tickets</h4>
              </div>
				
				
						<div class="col-xs-3 pull-right">
						<ul class="sub-menu">
						  <li class="sub-menu-item hidden">
							<a href="#" onclick="openPagina('cad','<?= Util::request("pag") ?>','');" 
							  class="action" data-toggle="tooltip" data-placement="left" title="Criar Novo">
							  <span class="icon icon-file2 text-new"></span>
							</a>
						  </li>
						  <li class="sub-menu-item">
							<a href="" onclick="openPrint('listar','<?= Util::request("pag") ?>','','html');" class="action" data-toggle="tooltip" data-placement="bottom" title="Imprimir">
							  <span class="icon icon-print text-print"></span>
							</a>
						  </li>
						  <li class="sub-menu-item">
							<a href="" onclick="openPrint('listar','<?= Util::request("pag") ?>','','');" class="action" data-toggle="tooltip" data-placement="right" title="Exportar Excel">
							  <span class="icon icon-file-excel text-export"></span>
							</a>
						  </li>
						</ul>
					  </div>
              <? } ?>
	</div><!-- End Row -->
	<table class="table table-hover table-condensed"   <? if ( Util::request("exp_excel") == "" ) { ?> border="0" <? } else { ?> border="1" <? } ?>	>
    <thead>
	 <tr  class="trheader">
     
			  
				<th  align="center" class="header">ID</th>
				
             
			  
				<th  align="center" class="header">Código/Ordem</th>
				

			  
				<th  align="center" class="header">Título</th>
				
			  
				<th  align="center" class="header">Módulos Associados</th>
				
             

			  
				<th  align="center" class="header">Ferramentas</th>
				
             
	 
	    <? if ( Util::request("exp_excel") == "" ) { ?>
			<th></th>
		<? } ?>	
	 </tr>
	 </thead>
	 <tbody>
<?php

$prefixo = "p1_";

$filtro = "";

  
		     
  
		        if ( Util::request("titulo") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("titulo"))  );
			  
			         $filtro .= " and upper(p.titulo) like upper('%".$strfilt."%') ";
			  }   
		       
  
		        if ( Util::request("codigo") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("codigo"))  );
			  
			         $filtro .= " and upper(p.codigo) like upper('%".$strfilt."%') ";
			  }   
		       
  
		        if ( Util::request("texto") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("texto"))  );
			  
			         $filtro .= " and p.texto like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("modulos") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("modulos"))  );
			  
			         $filtro .= " and p.modulos_txt like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("ferramentas") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("ferramentas"))  );
			  
			         $filtro .= " and p.ferramentas_txt like '%".$strfilt."%' ";
			  }   
		       

if ( $field_order != "" ){
	
       $filtro.= " order by "  . $field_order . " " .  $field_order_type;
}

$sql = " select * from competicao_fase p where 1 = 1 ". $filtro;


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
	 <tr>

		 
		
			 <td align="center" class="td">&nbsp;<?=   $item["id"] ?></td> 
       
      
			 <td align="center" class="td">&nbsp;<?= $item["codigo"] ?></td> 
 
      
			 <td align="left" class="td">&nbsp;<?= $item["titulo"] ?></td> 
			 <td align="left" class="td">&nbsp;<?= $item["modulos_txt"] ?></td> 
			 <td align="left" class="td">&nbsp;<?= $item["ferramentas_txt"] ?></td> 
       
		
		<? if ( Util::request("exp_excel") == "" ) { ?>
	                <td>
	                    <a href="#" onclick="load('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
	                      <span class="icon icon-action icon-pencil text-warning"></span>
	                    </a>
	                    <a href="#"  onclick="excluir('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Excluir">
	                      <span class="icon icon-action icon-remove2 text-danger"></span>
	                    </a>
	                </td>
         <? } ?> 
		
		
	</tr>
     
     
	<?php 
	
	  } ?>
     
	            <?php if (Util::NVL(count($lista),0) == 0){ ?>
                 
                  <tr>
                    <td colspan="8" class="f-tabela-texto">
                      N&atilde;o h&aacute; dados a serem exibidos!
                    </td>
                  </tr>
                <?php }?>
	 

	 </tbody>
	  <? if ( Util::request("exp_excel") == "" ) { ?>
                <tfoot>
                	<tr>
                 		<td colspan="8">
                    	<div class="form-inline">
                      	<div class="form-group form-group-sm">
                          <input name="url" type="hidden" value="<?php 
     						//echo Util::paginaAtual("url,urlnoId") ?>">
                          <?php 
                            MostrarPaginacao(Util::NVL( Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"),constant("K_PAG_MINIMUN")),
                            Util::NVL(Util::getParam($_REQUEST, $prefixo."selPagina"),1),$total,"frm", true, true, $prefixo);
                          ?>
                      	</div>
                    	</div>
                  	</td>
                	</tr>
              	</tfoot>
              	<? } ?>
  </table>
        </div><!-- End Bs Exemple -->
      	</div><!-- End col 12 -->
  	</div><!-- End Row -->


</div><!-- END FIELDBOX -->

</form>

<div class="interMenu">
	<?php
        
        $ferramenta = inc_ferramenta::findFerramentaByCodigo("competicao");
        
        if (is_array($ferramenta)) {
        
                   botaoVoltar("index.php?mod=cad&pag=ferramenta&id=". $ferramenta["id"]."&acao=LOAD"  );
        
        }
        ?>
</div>

<script >
 function load(id)
 {
	var f = document.forms[0];
	///f.action = "cad_public.competicao_fase.php?acao=<?php echo Util::$LOAD?>&id="+id;
	f.action =  "index.php?pag=competicao_fase&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 
}

function excluir(id)
{
       if (! confirm("Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro."))
	     return; 
		
	var f = document.forms[0];
	f.action =  "delete.php?pag=competicao_fase&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 	
		
}

</script>