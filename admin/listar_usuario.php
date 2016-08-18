<?php
  require_once("inc_usuario.php");

  $ur = Util::paginaAtual($_REQUEST, "url,urlnoId");
  $_SESSION["urlant"] = $ur ;
  $_SESSION["array_querie_ant"] =  Util::paginaAtual($_REQUEST, "url,urlnoId",false);

  $prefixo = "_p1";

  $field_order_type = Util::request("field_order_type");
  $field_order = Util::request("field_order");
?>
<?php Util::mensagemCadastro() ?>
<form method="post" name="frm" action="index.php?pag=usuario&mod=<?php echo Util::request("mod") ?>">
  <input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
      <div class="row">
        <div class="col-xs-12">
          <h1 class="sistem-title">Todos os Usuários</h1>
            <div class="form-inline">
              <h4 class="sistem-subtitle">Filtrar por:</h4>
              <!--  <h4 class="sistem-subtitle">Ordenar por:</h4> -->
              <label class="sr-only" for="nome_completo">Nome</label>
              <input type="text" placeholder="Nome" class="form-control" name="nome_completo" value="<?= Util::request("nome_completo") ?>">

              <label class="sr-only" for="email">E-mail</label>
              <input type="text" placeholder="E-mail" class="form-control" name="email" value="<?= Util::request("email") ?>"   maxlength="300" style="width: 140px">
			         <div class="hidden">
              <label class="sr-only" for="data_cadastro_inicio">Data Inicio</label>
              <input type="text" class="form-control temData" name="data_cadastro_inicio" value="<?=Util::PgToOut( Util::request("data_cadastro_inicio"), true) ?>" onkeypress=" return mascaraData(event)">
          
              <label class="sr-only" for="data_cadastro_fim">Data Fim</label>
              <input type="text" class="form-control temData" name="data_cadastro_fim" value="<?=Util::PgToOut( Util::request("data_cadastro_fim"), true) ?>" onkeypress=" return mascaraData(event)">

              <label class="sr-only" for="cpf">CPF</label>
              <input type="text" class="form-control" name="cpf" value="<?= Util::request("cpf") ?>">

              <label class="sr-only" for="rg">RG</label>
              <input type="text" class="form-control" name="rg" value="<?= Util::request("rg") ?>">

              <label class="sr-only" for="telefone">Telefone</label>
              <input type="text" class="form-control" name="telefone" value="<?= Util::request("telefone") ?>">
              
              <label class="sr-only" for="telefone2">Telefone 2</label>
              <input type="text" class="form-control" name="telefone2" value="<?= Util::request("telefone2") ?>">
			         </div>
              <label class="sr-only" for="cidade">Cidade</label>
              <input type="text" placeholder="municipio" class="form-control" name="municipio" value="<?= Util::request("municipio") ?>">
			     <div class="hidden">
              <label class="sr-only" for="uf">UF</label>
              <input type="text" class="form-control" name="uf" value="<?= Util::request("uf") ?>">
			     </div>
              <label class="sr-only" for="field_order">Identificação</label>
                <select placeholder="" class="form-control" name="field_order">
                  <option value="id" <? if ($field_order == "id"){ echo ( " selected "); } ?>>ID</option>
                        <option value="nome_completo" <? if ($field_order == "nome_completo"){ echo ( " selected "); } ?>>Nome Completo</option>

                        <option value="data_cadastro" <? if ($field_order == "data_cadastro"){ echo ( " selected "); } ?>>Data de Cadastro</option>

                        <option value="email" <? if ($field_order == "email"){ echo ( " selected "); } ?>>Email</option>

                        <option value="cpf" <? if ($field_order == "cpf"){ echo ( " selected "); } ?>>CPF</option>

                        <option value="rg" <? if ($field_order == "rg"){ echo ( " selected "); } ?>>RG</option>

                        <option value="telefone" <? if ($field_order == "telefone"){ echo ( " selected "); } ?>>Telefone</option>

                        <option value="telefone2" <? if ($field_order == "telefone2"){ echo ( " selected "); } ?>>Telefone 2</option>

                        <option value="municipio" <? if ($field_order == "municipio"){ echo ( " selected "); } ?>>Nome do município</option>

                        <option value="uf" <? if ($field_order == "uf"){ echo ( " selected "); } ?>>UF</option>
                </select>
              <label class="sr-only" for="field_order_type">Ordenação</label>
                <select placeholder="" class="form-control" name="field_order_type">
                  <option value="asc" <? if ($field_order_type == "asc"){ echo ( " selected "); } ?>>Ascendente</option>
                  <option value="desc" <? if ($field_order_type == "desc"){ echo ( " selected "); } ?>>Descendente</option>
                </select>
              <button type="button" class="btn btn-primary botao" value="Pesquisar" onclick="document.frm.submit()">Buscar</button>
            </div><!-- End Form -->
        </div><!-- End Col 12 -->
      </div><!-- End Row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="bs-example">
            
            <div class="row">
              <div class="col-xs-3">
                <h4 class="sistem-subtitle">Lista de Usuários</h4>
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
                <? } ?>
              </div>
            </div><!-- End Row -->
           
            <table class="table table-hover table-condensed">
              <thead>
                <td>ID</td>
                <td>Nome</td>
                <td>Data de Cadastro</td>
                <td>E-Mail</td>
                <td>Verificado</td>
                <td>CPF</td>
                <td>RG</td>
                <td>Telefone</td>
                <td>Município</td>
                <td>UF</td>
                <td></td>
              </thead>
              <tbody>
              <?php
                $prefixo = "p1_";
                $filtro = "";
                if ( Util::request("id") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("id"))  );
                  $filtro .= " and p.id like '%".$strfilt."%' ";
                }   
                if ( Util::request("nome_completo") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("nome_completo"))  );
                  $filtro .= " and p.nome_completo like '%".$strfilt."%' ";
                }   
            //------------------ Data de Cadastro -------------------------------
                if ( Util::request("data_cadastro_inicio") != "" ){
                   $filtro .= " and p.data_cadastro >= '"  . Util::dataPg( Util::request("data_cadastro_inicio") )."' ";
                }
                if ( Util::request("data_cadastro_fim") != "" ){
                   $filtro .= " and p.data_cadastro <= '"  . Util::dataPg( Util::request("data_cadastro_fim") )."' ";
                }
                if ( Util::request("email") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("email"))  );
                  $filtro .= " and p.email like '%".$strfilt."%' ";
                }   
                if ( Util::request("cpf") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("cpf"))  );
                  $filtro .= " and p.cpf like '%".$strfilt."%' ";
                }   
                if ( Util::request("rg") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("rg"))  );
                  $filtro .= " and p.rg like '%".$strfilt."%' ";
                }   
                if ( Util::request("telefone") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("telefone"))  );
                  $filtro .= " and p.telefone like '%".$strfilt."%' ";
                }   
                if ( Util::request("telefone2") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("telefone2"))  );
                  $filtro .= " and p.telefone2 like '%".$strfilt."%' ";
                }   
                if ( Util::request("municipio") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("municipio"))  );
                  $filtro .= " and p.municipio like '%".$strfilt."%' ";
                }   
                if ( Util::request("uf") != "" ){
                  $strfilt = trim( str_replace("'","''", Util::request("uf"))  );
                  $filtro .= " and p.uf like '%".$strfilt."%' ";
                }   
                if ( $field_order != "" ){
                  $filtro.= " order by "  . $field_order . " " .  $field_order_type;
                }

                $sql = " select * from usuario p where 1 = 1 ". $filtro;

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

              for ($z =0; $z<= $fim ; $z++){
                if ($z >= $fim)
                break;
      
                if ($z < $inicio)
                continue;
      
              $item  = $lista[$z];
              $img = "edit.png";
              $title = "Editar";
              ?>
                <tr>
                  <td><?=  Util::numeroTela( $item["id"], true);  ?></td>
                  <td><?= $item["nome_completo"] ?></td>
                  <td><?=  Util::PgToOut( $item["data_cadastro"], true);  ?></td>
                  <td><?= $item["email"] ?></td>
                  <td><?= $item["verificado_email"] ?"Sim":"Não"; ?></td>
                  <td><?= $item["cpf"] ?></td>
                  <td><?= $item["rg"] ?></td>
                  <td><?= $item["telefone"] ?></td>
                  <td><?= $item["municipio"] ?></td>
                  <td><?= $item["uf"] ?></td>
                  <? if ( Util::request("exp_excel") == "" ) { ?>
                  <td>
                      <table>
                          <tr>
                              <td>
                    <a href="#" onclick="load('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
                      <span class="icon icon-action icon-pencil text-warning"></span>
                    </a></td><td>
                      <a href="frame_envia_mensagem_interna.php?id_usuario=<?php echo $item["id"] ?>"  class="action iframe_modal" data-toggle="tooltip" data-placement="top" title="Enviar Mensagem Interna">
                      <span class="icon icon-action icon-mail3 text-danger"></span>
                      </a></td>
                          </tr>
                      </table>
                  </td>
                  <? } ?>
                </tr>
                <?php } ?>
                <?php
                if (Util::NVL(count($lista),0) == 0){
                ?>
                 <tbody>
                  <tr>
                    <td colspan="12" class="f-tabela-texto">
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
            </table>
          </div><!-- End BS-Example -->
        </div><!-- Enc Col -->
    </div><!-- End Row -->
<? } ?>
</form>

<script >
 function load(id){
    var f = document.forms[0];
	   ///f.action = "cad_usuario.php?acao=<?php echo Util::$LOAD?>&id="+id;
	   f.action =  "index.php?pag=usuario&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
      f.submit(); 
  }

function excluir(id){
     if (! confirm("Deseja realmente excluir?. Isto ir&aacute; remover tamb&eacute;m todas as depend&ecirc;ncias deste registro."))
	     return; 
		
	   var f = document.forms[0];
	   f.action =  "delete.php?pag=usuario&mod=cad&acao=<?php echo Util::$LOAD?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
      f.submit();	
}


    
</script>