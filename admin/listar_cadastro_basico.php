<?php
	//require_once("ap_config.php");
	$ur = Util::paginaAtual($_REQUEST, "url,urlnoId");
	$_SESSION["urlant"] = $ur ;
	$_SESSION["array_querie_ant"] =  Util::paginaAtual($_REQUEST, "url,urlnoId",false);
	$prefixo = "_p1";
	//print_r( $_SESSION["array_querie_ant"]  );
?>
<?php Util::mensagemCadastro() ?>
<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
	<input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
	<input type="hidden" name="mn" value="<?php echo Util::request("mn") ?>" >
	<div class="fieldBox">
		<div class="row">
        	<div class="col-xs-12">
          		<h1 class="sistem-title"><?= connAccess::executeScalar($oConn, " select descricao from tipo_cadastro_basico where id = ". Util::NVL(Util::request("tipo"), " 0 ")) ?> </h1>
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
        	<div class="col-xs-12">
        		<div class="bs-example">
        			<div class="row">
        			<div class="col-xs-3">
              		</div>
              		<div class="col-xs-3 pull-right">
              		<? if ( Util::request("exp_excel") == "" ) { ?>
              			<ul class="sub-menu">
		                  <li class="sub-menu-item">
		                    <a href="#" onclick="openPagina('cad','<?= Util::request("pag") ?>','&tipo=<?=Util::NVL(Util::request("tipo"), " 0 ")?>');" 
		                      class="action" data-toggle="tooltip" data-placement="left" title="Criar Novo">
		                      <span class="icon icon-file2 text-new"></span>
		                    </a>
		                  </li>
		                  <li class="sub-menu-item">
		                    <a href="" onclick="openPrint('listar','<?= Util::request("pag") ?>','&tipo=<?=Util::NVL(Util::request("tipo"), " 0 ")?>','html');" 
		                    	class="action" data-toggle="tooltip" data-placement="bottom" title="Imprimir">
		                      <span class="icon icon-print text-print"></span>
		                    </a>
		                  </li>
		                  <li class="sub-menu-item">
		                    <a href="" onclick="openPrint('listar','<?= Util::request("pag") ?>','&tipo=<?=Util::NVL(Util::request("tipo"), " 0 ")?>','');" 
		                    	class="action" data-toggle="tooltip" data-placement="right" title="Exportar Excel">
		                      <span class="icon icon-file-excel text-export"></span>
		                    </a>
		                  </li>
		                </ul>
		            <? } ?>
		            </div>
              		</div><!-- End Row -->
              		<table class="table table-hover table-condensed">
		            	<thead>
			                <th>ID</th>
			                <th>Nome</th>
			                <? if ( Util::request("tipo") == "2" && false ){ ?>
		            		<th>Peso</th>
		 	 				<? } ?>
			                <th></th>
		              	</thead>
		              	<tbody>
	              	<?php
						$prefixo = "p1_";
						$tipo = Util::request("tipo");
						$filtro = " id_tipo_cadastro_basico = ". Util::NVL( $tipo, 1 );

						if (Util::request("txtfiltro") != "" )
    					$filtro .= " and upper(descricao) like upper('%".Util::request("txtfiltro")."%') ";

						$ordem = "descricao";
						$lista = connAccess::fastQuerie($oConn, "cadastro_basico",$filtro,$ordem);
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
  							<td><?=  $item["id"]  ?></td>
	      					<td><?=  $item["descricao"]  ?></td> 
	 	 					<? if ( Util::request("tipo") == "2" && false  ){ ?>
	           				<td><?= Util::numeroTela(  $item["campo1"], 1 )  ?></td> 
							<? } ?>
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
  						<?php } ?>
  						<?php if (Util::NVL(count($lista),0) == 0){ ?>
		                 <tbody>
		                  <tr>
		                    <td colspan="3">
		                      N&atilde;o h&aacute; dados a serem exibidos!
		                    </td>
		                  </tr>
		                <?php }?>
		              </tbody>
		              <? if ( Util::request("exp_excel") == "" ) { ?>
		              <tfoot>
		                <tr>
		                  <td colspan="11">
		                    <div class="form-inline">
		                      <div class="form-group form-group-sm">
		                          <input name="url" type="hidden" value="<?php //echo Util::paginaAtual("url,urlnoId") ?>">
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
        		</div><!-- End Bs Example -->
    		</div><!-- End Col 12 -->
		</div><!-- End Row -->
	</div><!-- End FieldBox -->
</form>
<script >
 function load(id)
 {
	var f = document.forms[0];
	f.action =  "index.php?pag=<?php echo Util::request("pag") ?>&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 
}

function excluir(id)
{
     if (! confirm("Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro."))
	     return; 
		
	var f = document.forms[0];
	f.action =  "<?= K_RAIZ ?>delete.php?pag=<?php echo Util::request("pag") ?>&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
    f.submit(); 	
		
}
</script>