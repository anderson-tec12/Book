<?php

        require_once("config.php");
        
        $server = 'Facebook';
	$redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_facebook.php';

        
	
	$client_id = $auth_config["facebook_client_id"]; $application_line = __LINE__;
	$client_secret = $auth_config["facebook_client_secret"];
        
        
           if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])){
                              // Informe o id da app
                              $appId = $client_id;
                              // Senha da app
                              $appSecret = $client_secret;
                              // Url informada no campo "Site URL"
                              $redirectUri = urlencode($redirect_uri);
                              // Obtém o código da query string
                              $code = $_GET['code'];

                              // Monta a url para obter o token de acesso
                              $token_url = "https://graph.facebook.com/oauth/access_token?"
                              . "client_id=" . $appId . "&redirect_uri=" . $redirectUri
                              . "&client_secret=" . $appSecret . "&code=" . $code;

                              die("<br>". $token_url . "<br>");
                              // Requisita token de acesso
                              $response = @file_get_contents($token_url);

                              if($response){
                                $params = null;
                                parse_str($response, $params);

                                // Se veio o token de acesso
                                        if(isset($params['access_token']) && $params['access_token']){
                                          $graph_url = "https://graph.facebook.com/me?access_token="
                                          . $params['access_token'];

                                          // Obtém dados através do token de acesso
                                          $user = json_decode(file_get_contents($graph_url));

                                          // Se obteve os dados necessários
                                          if(isset($user->email) && $user->email){

                                            /*
                                            * Autenticação feita com sucesso. 
                                            * Loga usuário na sessão. Substitua as linhas abaixo pelo seu código de registro de usuários logados
                                            */
                                            $_SESSION['user_data']['email'] = $user->email;
                                            $_SESSION['user_data']['name'] = $user->name;

                                            $user["email"] =  $user->email;
                                            /*
                                            * Aqui você pode adicionar um código que cadastra o email do usuário no banco de dados
                                            * A cada requisição feita em páginas de área restrita você verifica se o email
                                            * que está na sessão é um email cadastrado no banco
                                            */
                                          }

                                        }else{
                                          $_SESSION['fb_login_error'] = 'Falha ao logar no Facebook';
                                        }

                                      }else{
                                        $_SESSION['fb_login_error'] = 'Falha ao logar no Facebook';
                                      }

                                    }else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['error'])){
                                      $_SESSION['fb_login_error'] = 'Permissão não concedida';
                                    }
        
        
        $url = 'https://www.facebook.com/dialog/oauth?client_id='.$client_id.
                '&scope=email&redirect_uri='. urlencode($redirect_uri);
        
        
            
        
        
        
        ?>
<script>
    document.location.href = '<?=$url?>';
</script>
    