<?
//include functions to componente_template_item
class componente_template_item{
    
    public static function temCampoInput($id_componente_template){
        
              $lst =   componente_template_item::getListaItens($id_componente_template, " and ( upper(i.codigo) like '%INPUT%' or upper(i.codigo) like '%KAPPA%' )  ");
        
              return count($lst) > 0;
              
    }
    
    
    
     public static function getValorItemTemplate($id_template_item, $id_registro, $tabela, $campo = "valor")
    {
        global $oConn;
        
        $registro = connAccess::fastOne($oConn,"valor_item_template", " id_template_item = ". $id_template_item.
                " and id_registro = ".$id_registro." and tabela='".$tabela."' " );
             
        if (is_array($registro))
        {
            return $registro[$campo];
        }
        
        return "";
    }
    
    public static function setValorItemTemplate($valor, $obs,  $id_template_item, $id_registro, $tabela)
    {
        global $oConn;
        global $id_usuario_logado;
        
        $registro = connAccess::fastOne($oConn,"valor_item_template", " id_template_item = ". $id_template_item.
                " and id_registro = ".$id_registro." and tabela='".$tabela."' " );
        
        
        if (!is_array($registro))
        {
            $registro = $oConn->describleTable("valor_item_template");
            
        }
        
        $registro["tabela"] = $tabela;
        $registro["id_registro"] = $id_registro;
        $registro["id_template_item"] = $id_template_item;
        //$registro["id_ticket"] = $relato["id_ticket"];
        
        if ( $tabela == "relato"){
            
            $relato = connAccess::fastOne($oConn,"relato"," id = ". $id_registro);
            
            $registro["id_ticket"] = $relato["id_ticket"];
        }
        
        $registro["id_usuario"] = $id_usuario_logado;
        $registro["valor"] = $valor;
        $registro["obs"] = $obs;
        
        connAccess::nullBlankColumns($registro);
        
        if ( ! $registro["id"] ){
            
            connAccess::Insert($oConn,$registro,"valor_item_template","id", true);
        }else{
            
            connAccess::Update($oConn,$registro,"valor_item_template","id");
        }
        
        
    }
    
    
    
    public static function getComponenteTemplate($id ){
          global $oConn;
          
          
          $sql = " select ct.*, ic.imagem as imagem01, ic2.imagem as imagem02 
                from custom.componente_template ct 
             left join icone ic on ic.id = ct.id_icone1
             left join icone ic2 on ic2.id = ct.id_icone2
             where 1 = 1 and ct.id = ". $id. "  ";
          
          $lista = connAccess::fetchData($oConn, $sql );
        
          
          return $lista;
        
    }
    
    
       public static function getListaComponenteTemplate(  ){
          global $oConn;
          
          
          $sql = " select ct.*, ic.imagem as imagem01, ic2.imagem as imagem02 
                from custom.componente_template ct 
             left join icone ic on ic.id = ct.id_icone1
             left join icone ic2 on ic2.id = ct.id_icone2
             where 1 = 1 and coalesce(ct.status,'') not in ('rascunho') ";
          
          $lista = connAccess::fetchData($oConn, $sql );
        
          
          return $lista;
        
    }
    
    
    
    public static function getListaItens($id_componente_template, $comp = ""){
        global $oConn;
        
           $sql = " select ti.*, i.codigo from custom.componente_template_item ti "
                                    ."  left join custom.item_componente i on i.id = ti.id_item_componente "
                                    ."  where ti.id_componente_template = ".$id_componente_template. $comp . " and coalesce(ti.status,'') not in ('rascunho') order by ti.ordem ";
        
           return connAccess::fetchData($oConn, $sql );
        
    }
    
    
    public static function writeHtmlItem($codigo, $item, $id_relato = ""){
        
        global $caminho_kappa;
        
        $codigo = strtolower($codigo);
        
        if ( $codigo == "video" ){
            
            $youtubeKey = explode("?v=", $item["texto"]);   // https://www.youtube.com/watch?v=Fu-tkFHHaDY
            
            $key = "";
            //print_r( $youtubeKey );
            if ( count($youtubeKey) > 1 ){
                
                $key = $youtubeKey[1];
                 
                if ( trim($key) != "") {
            ?>
                    <div class="video"><iframe width="auto" height="auto"
                                               src="//www.youtube.com/embed/<?=trim($key)?>?theme=light&amp;autohide=1&amp;showinfo=0;wmode=opaque;border=none;iv_load_policy=1;rel=0" 
                                               frameborder="0" allownetworking="internal"></iframe></div>
	
            <?
                }
            }
        }
        if ( $codigo == "kappa" ){ ?>
                          
              
              <input type="hidden" name="comentario_nota" value="<?=$item["texto"] ?>" >
       
              <div class="botoes_kappa">
  		  <? require_once($caminho_kappa); 
                  
                  $valor = componente_template_item::getValorItemTemplate($item["id"], $id_relato, "relato");
                  if ( $valor != "" && $id_relato != "" ){
                      echo("<script type='text/javascript'>setNota('".trim($valor)."'); </script>");
                  }
                  ?>
              </div>
            
          <?  
        }
        
        
        if ( $codigo == "texto" ){
            ?>
                   <h3><?=$item["texto"]?></h3>
            <?
        }
        if ( $codigo == "texto-m" ){
            ?>
                   <div class="form">
                   <label><?=$item["texto"]?></label>
                   </div>
            <?
        }
        if ( $codigo == "input" || $codigo == "input-text" ){
            
            $valor = componente_template_item::getValorItemTemplate($item["id"], $id_relato, "relato");
            ?>
                   <div class="form">
                       <input type="text" name="item_valor_<?= $item["id"] ?>" value="<?= $valor ?>"/>
                   </div>
            <?
        }
          if ( $codigo == "kappa"  && false ){
            ?>
            <div class="botoes_kappa">
  				<img src="images/botoes_kappa.png"/>
            </div>
          <? }
            if ( $codigo == "rel" ){  ?>
                
          <a href="#" class="button bt_centro" name="">CLIQUE PARA VER A LISTA DE COMPONENTES QUE ESCOLHEMOS PARA O “Pessoas (físicas & jurídicas)”</a></td>
	
           <? }
	       if ( $codigo == "imagem" ){
            ?>
            <div class="imagem">
                
                <?
                 if ( strtolower( $item["codigo"] ) == "imagem" && $item["texto"] != "" ){

                        $dir_image  = K_RAIZ_DOMINIO .  "files/componente_template/";
                        $final_img =$dir_image.trim($item["texto"]); ?>
                        
                            <img src="<?=$final_img?>" >
                   <?
                    }
                    
                    ?>
                
            </div>
          <? }   
        
        
    }
    
    
    
    
    
    
    
}



?>