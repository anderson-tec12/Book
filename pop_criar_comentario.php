<?
require_once("inc_protecao_usuario.php"); 

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));


$id = Util::request("ID");
$acao = Util::request("acao");
$retorno = Util::request("retorno");

if ( $id == "")
  die("Vazio!");

$registro = connAccess::fastOne($oConn,"marcacao"," id = ". $id );

$registro_tipo_marcacao  =  connAccess::fastOne($oConn,"marcacao_tipo"," id = ". $registro["id_tipo_marcacao"] );

    //post-fogo


if ( $acao == "salvar" && Usuario::getToken($id_usuario_logado) == Util::request("token") ){


 $item = $oConn->describleTable("avaliacao_kappa");
 $prefixo = "";
 $item["id_ticket"] = "";
 $item["id_registro"] = $id;
 $item["nome_tabela"] = "marcacao";
 $item["id_componente_template"] = "";
 $item["id_avaliacao_kappa_pai"] = "";

        /*
        if ($id_pai != "") {
            $item["id_avaliacao_kappa_pai_usuario"] = connAccess::executeScalar($oConn, "select id_usuario from avaliacao_kappa where id = " . $id_pai);

            $nivel = KappaGrid::contaNivel($id_pai);

            if ($nivel >= 1) {
                $item["id_avaliacao_kappa_pai"] = KappaGrid::getIDPai($id_pai);
            }
        }
         * 
         */

        $item["nota"] = request($prefixo . "comentario_nota");
        $item["data"] = Util::getCurrentBDdate();
        $item["ressalva"] = Util::acento_para_html(request($prefixo . "comentario_texto"));
        // $item["id_usuario"] = SessionFacade::getIdLogado();

        if ($item["id_usuario"] == "") {
          $item["id_usuario"] = $id_usuario_logado;
        }

        //$item["id_usuario_avaliado"] = KappaGrid::tentaLocalizarUsuarioAvaliado($id_ticket, $nome_tabela, $id_registro);

        //$item["url_completa"] = Util::request("kappa_url_completa");
        connAccess::nullBlankColumns($item);
        //die("ooi ");
        
        $idAvaliacaoKappa = connAccess::Insert($oConn, $item, "avaliacao_kappa", "id");


        $url = "pop_index.php?pag=criar_comentario&ID=". $id."&retorno=". Util::request("retorno");
        
        die("<script>document.location.href='". $url. "'; </script> ");
      }    

      ?>


      <script src="admin/javascript/validacampos.js?t=9990" type="text/javascript"></script>

      <form  method="post" name="form_marcacao"  >


        <input type="hidden" name="pag" value="<?= Util::request("pag") ?>" >
        <input type="hidden" name="retorno" value="<?= Util::request("retorno") ?>" >
        <input type="hidden" name="acao" value="">
        <input type="hidden" name="id_usuario" value="<?=$id_usuario_logado ?>">
        <input type="hidden" name="token" value="<?= Usuario::getToken($id_usuario_logado) ?>">
        <input type="hidden" name="ID" value="<?= $id ?>" >
        <input type="hidden" name="ispostback" value="1" >

        <div class="container">
         <div class="cboxIframe container12 pop_post">

          <h1>Criar comentário</h1>

          <div class="column6"><!-- Quando não estiver logado, atualizar essa class para "column12" e despublicar o campo de formulário "form-group" -->
           <div class="box-line">
            <div class="content-popup">

              <img class="icon-post-box" src="files/marcacao_tipo/<?=$registro_tipo_marcacao["imagem"]?>">
              <h3><?=$registro["titulo"]?></h3>
              <? if ( trim($registro["localizacao"]) != "" ) { ?>
              <h5><?=$registro["localizacao"]?></h5>
              <? } ?> 
              <!-- Max 170 caracteres -->
              <p><?=$registro["texto"]?></p>
             <?
             $user = Usuario::getUser($registro["id_usuario"]);
             ?>
             <div class="user-name">
              <img class="avatar avatar-mini" src="<?= Usuario::mostraImagemUser($user["imagem"], $registro["id_usuario"])?>">
              <div class="name"><?=$user["nome_completo"]?> <?= Util::PgToOut($registro["data_cadastro"], true) ?></div>
            </div>
          </div>
        </div>
      </div>
     <? if ( SessionFacade::usuarioLogado() ) { ?>
      <div class="column6 form-group"><!-- Despublicar esse campo quando não estiver logado -->
       <textarea class="form-control" name="comentario_texto" id="comentario_texto" placeholder="Escreva até 250 caracteres" maxlength="250"></textarea>
       <input type="button" class="btn btn-small" value="Salvar" onclick="salvar()">
     </div>
     <? } ?>
     <div class="column12 comments">
      <?


      $sql = " select ak.*, us.nome_completo, us.imagem from avaliacao_kappa ak "
      . " left join usuario us on us.id = ak.id_usuario "
      . "  where ak.id_registro = ". $id. " and ak.nome_tabela='marcacao' order by ak.id desc  ";


      $lista = connAccess::fetchData($oConn, $sql );


      $titulo = "Comentários";
      if ( count($lista) <= 0 ) {  
        $titulo = "Seja o primeiro a comentar";

      }
      ?>
      <div class="title-line"><h2><?=$titulo?></h2></div>

      <?


      if ( count($lista) > 0 ) {       
       ?>

       <div class="list-comments">

        <?


        for ( $i = 0; $i < count($lista); $i++ ) { 


         $item = $lista[$i];


         ?>


         <div class="comments-user">
           <div class="user-name">
            <img class="avatar avatar-small" src="<?= Usuario::mostraImagemUser($item["imagem"], $item["id_usuario"])?>">
            <div class="name"><?= $item["nome_completo"] ?> <?= Util::PgToOut(  $item["data"], true) ?></div>
          </div>
          <div class="description">
            <h4><?= $item["ressalva"] ?></h4>
          </div>
        </div>

        <? } ?>

      </div>
      <? } ?>
    </div>

  </div><!-- /cboxIframe -->
</div><!-- /container -->

</form>

<script type="text/javascript">
 function valido(){


  var f = document.forms[0];

  if ( isVazio(f.comentario_texto, "Informe o comentário"))
    return false;


  return true;
}


function salvar(){

  var f = document.forms[0];

  if ( ! valido() )
    return false;

  f.acao.value = "salvar";
  f.target = "_self";
        //alert(f.target);
        f.submit();
        
      //  alert("Dei o submit? ");

    }

    // Modal
    $(document).ready(function () {
      parent.$.fn.colorbox.resize( {
        innerWidth: 980,
        innerHeight: $(document).height()
      });
    });
  </script>