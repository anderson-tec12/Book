<?php
$GarrMenus = array();

$GarrMenus[count($GarrMenus)] = array("key" => "ModCadastros", "nome" => "Cadastros", "path" => "",
    "itens" => getArrayItensMenu("ModCadastros"));

$GarrMenus[count($GarrMenus)] = array("key" => "ModTemplates", "nome" => "Livro", "path" => "custom",
    "itens" => getArrayItensMenu("ModTemplates"));

//$GarrMenus[count($GarrMenus)] = array("key" => "ModChaveDicotomica", "nome" => "Chave Dicotomica", "path" => "survay",
   // "itens" => getArrayItensMenu("ModChaveDicotomica"));


//$GarrMenus[count($GarrMenus)] = array("key" => "ModEmails", "nome" => "Emails", "path" => "",
  //  "itens" => getArrayItensMenu("ModEmails"));

//$GarrMenus[count($GarrMenus)] = array("key" => "ModConfiguracoes", "nome" => "Configurações", "path" => "custom",
//    "itens" => getArrayItensMenu("ModConfiguracoes"));




function podeAcessarFuncionalidade($key, $oConn) {
    return true;
}

function getListaMenuToCheks() {
    global $GarrMenus;

    $saida = array();

    for ($y = 0; $y < count($GarrMenus); $y++) {

        $grupo = $GarrMenus[$y]["key"] . " - " . $GarrMenus[$y]["nome"];

        $itens = $GarrMenus[$y]["itens"];

        for ($z = 0; $z < count($itens); $z++) {

            $ar = explode(",", $itens[$z]);

            $saida[count($saida)] = array("valor" => $ar[0], "texto" => $ar[1], "grupo" => $grupo);
        }
    }

    return $saida;
}

function getArrayItensMenu($key) {

    $saida = array();

    if ($key == "ModCadastros") {
        $saida[count($saida)] = "listar|usuario|||ModCadastros,Cadastro de Usuários,users";
        $saida[count($saida)] = "listar|marcacao_tipo|||ModCadastros,Categoria de marcação,keyword";
        $saida[count($saida)] = "listar|cadastro_basico|&tipo=3||ModCadastros,Município,settings";
        $saida[count($saida)] = "listar|comentario|||ModCadastros,Comentários,settings";
        
        
       // $saida[count($saida)] = "listar|profissional|||ModCadastros,Profissionais,professionals";
      //  $saida[count($saida)] = "listar|icone|||ModCadastros,Ícones,icons_mnu";
        
        
      //  $saida[count($saida)] = "listar|cadastro_basico|&tipo=5||ModCadastros,Palavras-Chave,keyword";
      //  $saida[count($saida)] = "listar|template_falacia||survay|ModCadastros,Falácias,fallacies";
        
      //  $saida[count($saida)] = "cad|conteudos_assinados_destaque|||ModCadastros,Destaque de Conteúdos Assinados,settings";
    
        //Otimize o Ritmo
      //  $saida[count($saida)] = "listar|otimize_ritmo_configuracao|||ModCadastros,Configuração Planeje Acordo,calendar2";
    }

    if ($key == "ModTicket") {
        $saida[count($saida)] = "listar|ticket|||ModTicket,Tickets,ticket";
        $saida[count($saida)] = "listar|acao_ticket|||ModTicket,Ações,actions";
    }

    if ($key == "ModTemplates") {
        $saida[count($saida)] = "listar|componente_template||custom|ModTemplates,Páginas,template_element";
        $saida[count($saida)] = "listar|capitulo||custom|ModTemplates,Capítulos,libreoffice";
       // $saida[count($saida)] = "listar|cadastro_basico|&tipo=4||ModTemplates,Capítulos,libreoffice";
        $saida[count($saida)] = "listar|item_componente||custom|ModTemplates,Elementos de página ,tools_template";
        //$saida[count($saida)] = "listar|template_newsletter||custom|ModTemplates,Template de Email ,email_template";
        //$saida[count($saida)] = "listar|template_item||survay|ModTemplates,Template de Objetivo ABCD,abcd_template";
        //$saida[count($saida)] = "listar|template_texto||custom|ModTemplates,Template de Texto,libreoffice";
      //  $saida[count($saida)] = "listar|modulo||custom|ModTemplates,Módulos,cabinet";
    }

    if ($key == "ModChaveDicotomica") {
        $saida[count($saida)] = "listar|enquete||survay|ModChaveDicotomica,Chaves ,dochotomous";
        $saida[count($saida)] = "listar|grupo_item||survay|ModChaveDicotomica,Grupo de Respostas,group_answers";
    }

      if ($key == "ModEmails") {
       // $saida[count($saida)] = "listar|assinantes_news|||ModEmails,Emails - Guia do Usuário ,pencil2";
       // $saida[count($saida)] = "listar|arquivo|||ModEmails,Arquivos do Portal ,file3";
        $saida[count($saida)] = "listar|news|||ModEmails,Newsletter E-mail,newspaper";
    }
    
    
    if ($key == "ModConfiguracoes") {
        //$saida[count($saida)] = "cad|termos_uso||custom|ModConfiguracoes,Termos de Uso de Contrato ,tools"; configurations
        $saida[count($saida)] = "cad|mensagens||custom|ModConfiguracoes,Mensagens de Email,pencil"; 
     
     //   $saida[count($saida)] = "listar|ferramenta||custom|ModConfiguracoes,Ferramenta,hammer";
    //    $saida[count($saida)] = "listar|modulo||custom|ModConfiguracoes,Módulo,cabinet";
      //  $saida[count($saida)] = "listar|ticket_nao_entendi_tipo_pergunta|||ModConfiguracoes,Perguntas componente Não Entendi ,question";
        
        
        
       // $saida[count($saida)] = "listar|tipo_item_newsletter||custom|ModConfiguracoes,Elementos de Template Email ,email_element_template";
    }


    return $saida;
}

function testa_mostraItemParaPerfil(array $perfis) {

    for ($y = 0; $y < count($perfis); $y++) {

        if (SessionFacade::temPerfil($perfis[$y])) {
            return false;
        }
    }

    return true;
}

function getTituloModuloSistema($key) {

    global $GarrMenus;

    for ($y = 0; $y < count($GarrMenus); $y++) {

        if ($GarrMenus[$y]["key"] == $key) {
            return $GarrMenus[$y]["nome"];
        }
    }
    return "";
}

function getFirstMenu($key, &$mod, &$pag) {

    global $GarrMenus;

    for ($y = 0; $y < count($GarrMenus); $y++) {

        if (strtolower($GarrMenus[$y]["key"]) == strtolower($key)) {
            $ar = $GarrMenus[$y]["itens"];

            $it = explode(",", $ar[0]);
            $keys = explode("|", $it[0]);
            $mod = $keys[0];
            $pag = $keys[1];
            return "";
        }
    }
    return "";
}

function getEscreveMenuModuloSistema($key) {

    global $GarrMenus;
    global $oConn;
    $saida = "";


    $tp_perfil = connAccess::executeScalar($oConn, " select campo1 from cadastro_basico where id in (  select perfil  from usuario where id =  " . SessionFacade::getIdLogado() . " ) ");
    $perfis_txt = connAccess::executeScalar($oConn, " select campo3 from cadastro_basico where id_tipo_cadastro_basico = 1 and campo1='" . $tp_perfil . "' ");

    $arrPermitido = new ArrayList(explode(",", $perfis_txt));

    $saida = "";

    for ($y = 0; $y < count($GarrMenus); $y++) {

        if ($GarrMenus[$y]["key"] == $key) {

            $itens = $GarrMenus[$y]["itens"];

            for ($zz = 0; $zz < count($itens); $zz++) {


                $item = $itens[$zz];

                $ar = explode(",", $item);
                $url = explode("|", $ar[0]);

                if (!SessionFacade::temPerfil(SessionFacade::PerfilAdministrador)) {

                    if (!$arrPermitido->contains($ar[0])) {

                        //continue; //Se não tem, nem escreve no menu..
                        //Por enquanto não vou usar isso, preciso de tudo no menu..
                    }
                }


                $continua = "";

                $ar_tipo = explode("&tipo=", $ar[0]);
                $tipo = @$ar_tipo[1];

                if ($tipo == "") {
                    if ((request("mod") == $url[0] &&
                            request("pag") == $url[1]) || request("pag") == $url[1]) {
                        $continua = ' class="current_icone_topo" ';
                    } else {
                        
                    }
                } else {
                    if (
                            request("pag") == $url[1] && request("tipo") == $tipo) {
                        $continua = ' class="current_icone_topo" ';
                    }
                    //(request("mod") == $url[0]
                    //	&&
                }

                $url_final = "index.php?mod=" . $url[0] . "&pag=" . $url[1] . @$url[2];

                //print_r($url);

                if ($url[0] == "#")
                    $url_final = "#";

                $saida .= "<li class='menu-item' onclick=\"mudaModulo('" . $url[0] . "','" . $url[1] . @$url[2] . "','" . $url[3] . "','" . $url[4] . "');\">
				<a class='action' data-placement='left' data-toggle='tooltip' data-original-title='" . $ar[1] . "'  
						 " . $continua . ">
							<span class='icon icon-" . $ar[2] . "'></span>
						</a></li>";
            }
            break;
        }
    }

    return $saida;
}

function mostraComboModuloSistemas() {

    global $GarrMenus;
    global $esteModulo;

    $pathModulo = "";
    ?>
    <select id="combo_menu" class="form-control" onchange="mudaModuloMenu(this.value);" name="selModulo" id="selModulo" title="Mudar para outro sistema">
        <?
        for ($i = 0; $i < count($GarrMenus); $i++) {

            $item = $GarrMenus[$i];

            if (SessionFacade::temAcessoAModulo($item["key"])) {
                $value = $item["path"] . ',' . $item["key"];
                ?>
                <option value="<?= $value ?>" <?
                if ($item["key"] == $esteModulo) {
                    echo " selected ";
                }
                ?> ><?= $item["nome"] ?></option>

                <?
            }
        }
        ?>
    </select>
    <script type="text/javascript">

        function mudaModuloMenu(value) {
            var res = value.split(",");
            this.mudaModulo("", "", res[0], res[1]);
        }

        function mudaModulo(mod, pag, path, menu) {
            //alert(path);
            //alert(menu);
            //alert(mod);
            
            
            var ars = pag.split("&");
            
            if ( ars.length > 1 ){
                pag = ars[0];                
            }

            var divFormRodape = document.getElementById("divFormRodape");

            var form = ""; // "<form method='post' name='FormRodape' id='FormRodape' action='index.php' >";
            form += "<input type='hidden' name='acao' value='change_path'>";
            form += "<input type='hidden' value='" + path + "' name='CurPasta'>";
            form += "<input type='hidden' value='" + menu + "' name='GrupoMenu'>";
            form += "<input type='hidden' value='" + pag  + "' name='pag'>";
            form += "<input type='hidden' value='" + mod + "' name='mod'>";
            if ( ars.length > 1 ){
                  for ( var i = 0; i < ars.length; i++ ){
                      
                             var vals = ars[i].split("=");
                             form += "<input type='hidden' value='" + vals[1] + "' name='"+vals[0]+"'>";
                      
                  }
                 
            }
            //form += "</form>";

            divFormRodape.innerHTML = form;

            var FormRodape = document.getElementById("FormRodape");
          //  alert( FormRodape );
          //  alert(divFormRodape );
            //alert(  divFormRodape.innerHTML );
            if (FormRodape != null) {
                FormRodape.submit();
            }
            //document.location.href='../'+ valor ;
        }

    </script>
    <?
}
?>