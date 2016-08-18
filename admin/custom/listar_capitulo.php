<?php
 //Deseja realmente excluir?. Isto ir� remover tamb�m todas as depend�ncias deste registro
require_once("inc_capitulo.php");

$ur = Util::paginaAtual($_REQUEST, "url,urlnoId");
$_SESSION["urlant"] = $ur ;
$_SESSION["array_querie_ant"] =  Util::paginaAtual($_REQUEST, "url,urlnoId",false);

$prefixo = "_p1";

$field_order_type = Util::request("field_order_type");
$field_order = Util::request("field_order");


?>
<?php Util::mensagemCadastro() ?>

<form method="post" name="frm"
 action="index.php?pag=capitulo&mod=<?php echo Util::request("mod") ?>">

<input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
<input type="hidden" name="mn" value="<?php echo Util::request("mn") ?>" >
<!-- Filtro -->

<div class="fieldBox">

   	<? if ( Util::request("exp_excel") == "" ) { ?>
	<div class="row">
    <div class="col-xs-12">
	<h1 class="sistem-title">Capítulo</h1>
     <div class="form-inline">
	 <h4 class="sistem-subtitle">Filtrar por:</h4>
                               
         <input type="text"  name="titulo" class="form-control" placeholder="Título" value="<?= Util::request("titulo") ?>"   maxlength="300">
		
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
						  <li class="sub-menu-item">
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
				
             

			  
				<th  align="center" class="header">Título</th>
				
             

			  
				<th  align="center" class="header">Data de Cadastro</th>
				
             

			  
				<th  align="center" class="header">Cor de Fundo</th>
				
             

			  
				<th  align="center" class="header">Cor do Texto</th>
				
             
	 
	    <? if ( Util::request("exp_excel") == "" ) { ?>
			<th></th>
		<? } ?>	
	 </tr>
	 </thead>
	 <tbody>
<?php

$prefixo = "p1_";

$filtro = "";

  
        
			   if ( Util::request("id_inicio") != "" ){
			  
			         $filtro .= " and p.id >= "  . Util::numeroBanco( Util::request("id_inicio") )." ";
			  }
			  if ( Util::request("id_fim") != "" ){
			  
			         $filtro .= " and p.id <= "  . Util::numeroBanco( Util::request("id_fim") )." ";
			  }
					 
					 
		       
  
		        if ( Util::request("titulo") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("titulo"))  );
			  
			         $filtro .= " and p.titulo like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("imagem") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("imagem"))  );
			  
			         $filtro .= " and p.imagem like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("texto") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("texto"))  );
			  
			         $filtro .= " and p.texto like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("poema") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("poema"))  );
			  
			         $filtro .= " and p.poema like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("poema_autor") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("poema_autor"))  );
			  
			         $filtro .= " and p.poema_autor like '%".$strfilt."%' ";
			  }   
		       
  
			  
			  //------------------ data_cadastro -------------------------------
			  if ( Util::request("data_cadastro_inicio") != "" ){
			  
			         $filtro .= " and p.data_cadastro >= '"  . Util::dataPg( Util::request("data_cadastro_inicio") )."' ";
			  }
			  if ( Util::request("data_cadastro_fim") != "" ){
			  
			         $filtro .= " and p.data_cadastro <= '"  . Util::dataPg( Util::request("data_cadastro_fim") )."' ";
			  }
			 
		       
  
		        if ( Util::request("cor_fundo") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("cor_fundo"))  );
			  
			         $filtro .= " and p.cor_fundo like '%".$strfilt."%' ";
			  }   
		       
  
		        if ( Util::request("cor_texto") != "" ){
				
				     $strfilt = trim( str_replace("'","''", Util::request("cor_texto"))  );
			  
			         $filtro .= " and p.cor_texto like '%".$strfilt."%' ";
			  }   
		       

if ( $field_order != "" ){
	
       $filtro.= " order by "  . $field_order . " " .  $field_order_type;
}

$sql = " select * from custom.capitulo p where 1 = 1 ". $filtro;


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

		 
		
			 <td align="right" class="td">&nbsp;<?=  Util::numeroTela( $item["id"], true);  ?></td> 
			 <td align="center" class="td">&nbsp;<?= $item["titulo"] ?></td> 
			 <td align="center" class="td">&nbsp;<?=  Util::PgToOut( $item["data_cadastro"], true);  ?></td> 
                         <td align="center" class="td"><input type="text" value="<?= $item["cor_fundo"] ?>" class="color" style="width: 80px"></td> 
			 <td align="center" class="td"><input type="text" value="<?= $item["cor_texto"] ?>" class="color" style="width: 80px"></td> 
       
		
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
                 		<td colspan="6">
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

<script type="text/javascript" src="javascript/jscolor/jscolor.js"></script>
<script >
 function load(id)
 {
	var f = document.forms[0];
	///f.action = "cad_custom.capitulo.php?acao=<?php echo Util::$LOAD?>&id="+id;
	f.action =  "index.php?pag=capitulo&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 
}

function excluir(id)
{
       if (! confirm("Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro."))
	     return; 
		
	var f = document.forms[0];
	f.action =  "delete.php?pag=capitulo&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 	
		
}

</script>