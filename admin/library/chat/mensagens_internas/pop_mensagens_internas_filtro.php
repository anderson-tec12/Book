<link rel="stylesheet" href="css/mensagens_internas.min.css" type="text/css" media="all"/>

<?  
require_once '../library/paginacao.php';
require_once 'chat/inc_chat.php';
$ticket = ticket::getLastTicket( $id_usuario_logado );
$id_ticket = $ticket["id"];
?>﻿


<form method="post" name="frm" action="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>">
  <input type="hidden" name="pag" value="<?= Util::request("pag") ?>" >
  <input type="hidden" name="cnt" value="1" >
  <input type="hidden" name="comp" value="<?= Util::request("comp") ?>" >
  <input type="hidden" name="mod" value="<?= Util::request("mod") ?>" >
  
  <input type="hidden" name="acao" value="" >
  <input type="hidden" name="id_ticket" value="<?= $id_ticket ?>" >
  <input type="hidden" name="ticket_id" value="<?= $id_ticket ?>" >



  <div class="container container-twelve comp_mensagens_internas" style="margin-top: -24px;">
    
    <div class="twelve columns">
      <div class="cabecalho_centro">
        <div class="titulo"><h2>Mensagens Internas</h2></div>
      </div>
    </div>

    <div class="twelve columns">
      <h3 style="text-align: left; margin: 0px 0 10px 0;">Filtro</h3>
      <div class="filtro">
        <input type="text" placeholder="Data" name="filtro_data" maxlength="10" onkeypress="return mascaraData(this, event)" value="<?= Util::request( "filtro_data" )  ?>">
        <input style="width: 410px;" type="text" id="filtro_mensagem" name="filtro_mensagem" placeholder="Mensagem" value="<?= Util::request( "filtro_mensagem" )  ?>">
        <?
        $usuarios = chat_ticket::getListaUsuariosMensagem($ticket["id"], $id_usuario_logado );
        ?>
        <select class="ms-choice" name="select_to" id="select_to">
          <option value="">Contato</option>
          <?
          Util::CarregaComboArray($usuarios, "id_usuario", "nome_completo", Util::request("select_to"));
          ?>
        </select>

        <input class="bt_buscar button" name="btSalvar" type="button" value="Filtrar" onclick="document.forms[0].submit() "/>
      </div>
    </div>
    <?

    $minina_qtde_por_pagina = 8;

    $sql          = " select msg.*, us_rem.nome_completo as nome_remetente  from chat_ticket cht                  
    inner join chat_ticket_participante part on ( part.id_chat = cht.id and part.id_usuario =  ". $id_usuario_logado ." ) 
    inner join chat_ticket_mensagem msg on msg.id_chat = cht.id 
    inner join chat_ticket_mensagem_status stat on ( stat.id_mensagem = msg.id and stat.id_usuario = ". $id_usuario_logado ." ) 
    left join usuario us_rem on us_rem.id = msg.id_usuario
    where cht.id_ticket = " . $id_ticket ;
    
    
    if (Util::request( "filtro_mensagem" ) != "")
      $sql .= " and upper(msg.mensagem) like  upper('%" . str_replace ("'","''", Util::request( "filtro_mensagem" )) . "%') ";

    if (Util::request( "select_to" )  != ""){
     
      $sql .= " and exists( select subpart.id from chat_ticket_participante subpart "
        . " where subpart.id_chat = cht.id and subpart.id_usuario = " . Util::request( "select_to" )  ." ) ";
        //$sql .= " and msg.id_usuario = ". Util::request( "select_to" );

}

if (Util::request( "filtro_data" ) != ""){
  $data = Util::request( "filtro_data" );
  
  $sql .= " and msg.data >= '" . Util::dataPg($data) . " 00:00:00' and  msg.data <= '" . Util::dataPg($data) . " 23:59:59' ";

}

$sql .= " order by msg.data asc  ";



$lista = connAccess::fetchData($oConn, $sql); 
$prefixo = "msg_";

   //Paginação..
$inicio = 0;
$total = Util::NVL(count($lista),0);
   //echo(" ---> ". $total);
   //print(  $this->result);
$fim = 1;

   //die (NVL(request("selQtdeRegistro"), constant("K_PAG_MINIMUN"))."------");
$tmp = SetaRsetPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"), $minina_qtde_por_pagina ),
 Util::NVL(Util::getParam($_REQUEST,$prefixo."selPagina"),1),$total,$inicio,$fim);

   // echo ( "---> ".  Util::NVL(Util::getParam($_REQUEST,$prefixo."selPagina"),1) );
$z = 0 ;
$tarr = explode("_",$tmp);
$inicio = $tarr[0];
$fim = $tarr[1];


?>
<div class="twelve columns">
  <div class="tabela">
    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Mensagem</th>
          <th>Contato</th>
        </tr>
      </thead>
      <tbody>
        
        <?            
        $z = 0 ;
        $tarr = explode("_",$tmp);
        $inicio = $tarr[0];
        $fim = $tarr[1];


        for ($z =0; $z<= $fim ; $z++)
        {
          if ($z >= $fim)
            break;

          if ($z < $inicio)
            continue;

          $item  = $lista[$z];

          ?>         
          <tr>
            <td><?=  Util::PgToOut( $item["data"], true);  ?></td>
            <td><?= $item["mensagem"] ?></td>
            <td><?= chat_ticket::getTituloChat( $item["id_chat"], $id_usuario_logado ); ?></td>
          </tr>

          <? } ?>
          
          
        </tbody>
      </table>
    </div>
  </div>


  <div class="twelve columns">
   <div class="paginacao_tabela">
    
    <? MostrarPaginacaoPainelControle(Util::NVL( Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"), $minina_qtde_por_pagina),
      Util::NVL(Util::getParam($_REQUEST, $prefixo."selPagina"),1),$total,"frm", true, true, $prefixo);
      ?>
      
    </div>
  </div>
  
  <div class="twelve columns">
    <a href="pop_index.php?pag=mensagens_internas&comp=mensagens_internas&ticket_id=<?=$ticket["id"]?>&comp=mensagens_internas" class="button bt_auto_menor">Voltar</a>
  </div>

</div><!-- /comp_mensagens_internas -->

</form>


<!-- Tamanho Padrão na altura -->
<script type="text/javascript">
  $(document).ready(function () {
    parent.$.colorbox.resize({
      innerWidth: 960,
      innerHeight: $(document).height()
    });
  });
</script>