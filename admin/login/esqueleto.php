<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LOGIN</title>
<style>
ul{
      
        padding-left: 0px;
        margin-left: 0px;  
        
}        
ul li{
        
        list-style: none;
        
}   
    
</style>
</head>

<body>
<form method="post" name="frm">
    <div class="login_botoes_grande" id="div_login_botoes_grande">
        <ul>
            <li>                
                <input type="button" name="btLoginEmailGrande" value="Criar conta usando Email" class="login_botao_email_grande" onclick="fn_chamalogin(this)" />
            </li>
            <li>                
        <input type="button" name="btLoginFacebookGrande" value="Criar conta com o Facebook" class="login_botao_facebook_grande" onclick="fn_chamalogin(this)"/>
            </li>
            
               <li>                
        <input type="button" name="btLoginGoogleGrande" value="Criar conta com o Google" class="login_botao_google_grande" onclick="fn_chamalogin(this)"/>
            </li>
            
               <li>                
        <input type="button" name="btLoginMicrosoftGrande" value="Criar conta com o Hotmail" class="login_botao_microsoft_grande" onclick="fn_chamalogin(this)"/>
            </li>
            
               <li>                
        <input type="button" name="btLoginTwitterGrande" value="Criar conta com o Twitter" class="login_botao_twitter_grande" onclick="fn_chamalogin(this)"/>
            </li>
            
        </ul>
        
    </div>
    
    <div id="div_login_cadastro" class="login_box_cadastro" > 
        
        <div class="login_botoes_pequeno" id="div_login_botoes_pequeno" style="display:none">
         <ul>
           
            <li>                
        <input type="button" name="btLoginFacebookPequeno" value="Criar conta com o Facebook" class="login_botao_facebook_pequeno" onclick="fn_chamalogin(this)"/>
            </li>
            
               <li>                
        <input type="button" name="btLoginGooglePequeno" value="Criar conta com o Google" class="login_botao_google_pequeno" onclick="fn_chamalogin(this)"/>
            </li>
            
               <li>                
        <input type="button" name="btLoginMicrosoftPequeno" value="Criar conta com o Hotmail" class="login_botao_microsoft_pequeno" onclick="fn_chamalogin(this)"/>
            </li>
            
               <li>                
        <input type="button" name="btLoginTwitterPequeno" value="Criar conta com o Twitter" class="login_botao_twitter_pequeno" onclick="fn_chamalogin(this)"/>
            </li>
            
        </ul>
        </div>
        
        
        <div class="login_box_cadastro_campos" id="div_login_campos_cadastro" style="display:none">
            <div class="login_box_cadastro_titulo">Cadastrar usando Email</div>
            <table>
                <tr>
                    <td>
                        <input type="text" name="login_cad_nome" placeHolder="Primeiro Nome"  class="login_cadastro_nome" />
                    </td>
                </tr>
                <tr>
                     <td>
                        <input type="text" name="login_cad_sobrenome" placeHolder="Sobrenome"  class="login_cadastro_sobrenome" />
                    </td>
                 </tr>
                <tr>    
                    
                     <td>
                        <input type="text" name="login_cad_email" placeHolder="E-mail"  class="login_cadastro_email" />
                    </td>
                  </tr>
                <tr>   
                      <td>
                        <input type="password" name="login_cad_senha" placeHolder="Senha" autocomplete="off"  class="login_cadastro_senha"  />
                    </td>
                     </tr>
                <tr>
                      <td>
                        <input type="password" name="login_cad_confirmar_senha" placeHolder="Confirmar Senha"  autocomplete="off" class="login_cadastro_senha" />
                    </td>
                </tr>
                <tr>
                    <td>
                         
        <input type="button" name="btLoginCadastroEmail" value="Cadastrar" class="login_botao_cadastrar_email" onclick="fn_chamalogin(this)"/>
                    </td>
                </tr>
                
            </table>
            
            
            
            
        </div>
        
         <div class="login_box_logon" id="div_login_logon" style="display:none">
             <table>
                 
                  <tr>    
                    
                     <td>
                        <input type="text" name="login_email" placeHolder="E-mail"  class="login_logon_email" />
                    </td>
                  </tr>
                   <tr>   
                      <td>
                        <input type="password" name="login_senha" placeHolder="Senha" autocomplete="off"  class="login_logon_senha"  />
                    </td>
                     </tr>
             </table>
        
        </div>
    </div>
    
    
    <div class="login_termo_uso">
        <p>Ao efetuar o cadastro você concorda com os <a href="#">Termos de Serviço</a> do possível acordo e a <a href="#">Política de Privacidade</a>.</p>   
    </div>
    
    <div class="login_rodape">
        <p>Já tem o cadastro? <a id="a_faz_login"  name="a_faz_login" onclick="fn_chamalogin(this)" href="#">Faça o Login</a></p>
        
    </div>
    
    <script type="text/javascript">
        function fn_chamalogin( obj ){
            
               var div_login_botoes_grande   = document.getElementById("div_login_botoes_grande");
               var div_login_botoes_pequeno        = document.getElementById("div_login_botoes_pequeno");
               var div_login_campos_cadastro = document.getElementById("div_login_campos_cadastro");
               var div_login_logon           = document.getElementById("div_login_logon");
            
            if ( obj.name.indexOf("EmailGrande") > -1){
                
                div_login_botoes_grande.style.display = "none"; //Escondo os botões grandes.
                div_login_botoes_pequeno.style.display = ""; //Mostro os botões pequenos.
                fn_setaNomesBotoesLogin(div_login_botoes_pequeno, true ); //Indicando os labels de criação de conta.
                div_login_campos_cadastro.style.display = "";
                div_login_logon.style.display = "none";
            }
            if ( obj.name.indexOf("a_faz_login") > -1){
                
                div_login_botoes_grande.style.display = "none"; //Escondo os botões grandes.
                div_login_botoes_pequeno.style.display = ""; //Mostro os botões pequenos.
                div_login_campos_cadastro.style.display = "none";
                div_login_logon.style.display = "";
                fn_setaNomesBotoesLogin(div_login_botoes_pequeno, false ); //Indicando os labels de login.
            }
            
        }
        
        function fn_setaNomesBotoesLogin(divPai, bl_criar ){
            
            var bts = divPai.getElementsByTagName("input");
            
            for ( var i =0; i < bts.length; i++){
                
               var botao = bts[i];
               
               if ( botao == undefined ||  botao.type == undefined ||  botao.type == null)
                   continue;
               
               if ( botao.type != "button" )
                   continue;
               
               if ( bl_criar ){
                    if ( botao.name.toLowerCase().indexOf("google") > 1 ){
                        botao.value = "Criar conta com o Google";
                    }
                    if ( botao.name.toLowerCase().indexOf("twitter") > 1 ){
                        botao.value = "Criar conta com o Twitter";
                    }
                    if ( botao.name.toLowerCase().indexOf("microsoft") > 1 ){
                        botao.value = "Criar conta com o Hotmail";
                    }
                    if ( botao.name.toLowerCase().indexOf("facebook") > 1 ){
                        botao.value = "Criar conta com o Facebook";
                    }
                    if ( botao.name.toLowerCase().indexOf("email") > 1 ){
                        botao.value = "Criar conta usando Email";
                        botao.style.display = "";
                    }
               }else{
                   
                   if ( botao.name.toLowerCase().indexOf("google") > 1 ){
                        botao.value = "Login com o Google";
                    }
                    if ( botao.name.toLowerCase().indexOf("twitter") > 1 ){
                        botao.value = "Login com o Twitter";
                    }
                    if ( botao.name.toLowerCase().indexOf("microsoft") > 1 ){
                        botao.value = "Login com o Hotmail";
                    }
                    if ( botao.name.toLowerCase().indexOf("facebook") > 1 ){
                        botao.value = "Login com o Facebook";
                    }
                     if ( botao.name.toLowerCase().indexOf("email") > 1 ){
                        botao.value = "Criar conta usando Email";
                         botao.style.display = "none";
                    }
               }
                
            }
            
        }
        
        function listarTodasClassesUsadas(){
            
            
            var allTags = document.body.getElementsByTagName('*');
            var classNames = {};
            for (var tg = 0; tg< allTags.length; tg++) {
                var tag = allTags[tg];
                if (tag.className) {
                  var classes = tag.className.split(" ");
                    for (var cn = 0; cn < classes.length; cn++){
                      var cName = classes[cn];
                      if (! classNames[cName]) {
                        classNames[cName] = true;
                      }
                    }
                }   
            }
            var classList = [];
            for (var name in classNames){
                document.write( "<br>" + name );
               //classList.push(name);
            }
            
            
            
        }
        
       //listarTodasClassesUsadas();
     </script>  
</form>
</body>
</html>
