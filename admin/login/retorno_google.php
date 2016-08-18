<?
require_once("config.php");
echo ("<h1>Retorno</h1>");


foreach ($_REQUEST as $key => $value){
   echo("<br><b>". $key ."</b> = " . $value );
}
$code = @$_GET["code"];
if ( $code != "" ){


$arr_token = getAccessTokenDetails($id_google, $google_secrets, $retorno_google , $code);
print_r(  $arr_token );

echo("<br>dados obtidos");
//$dados_do_cara = getUserDetails(  $code );

//print_r( $dados_do_cara );

}
function getUserDetails($access_token)
{
    $graph_url = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=". $access_token;
echo("<br>". $graph_url);
    $user = json_decode(file_get_contents($graph_url));
    if($user != null && isset($user->name))
        return $user;
 
    return null;
}

function getAccessTokenDetails($app_id,$app_secret,$redirect_url,$code)
{
   $dados_post =  array(
						"redirect_uri" => urlencode($redirect_url),
						"client_secret" =>  $app_secret,
						"grant_type" => "authorization_code",
						"code" => $code
						);
  $token_url = "https://accounts.google.com/o/oauth2/token";
      $token_url = "https://accounts.google.com/o/oauth2/token?"
      . "client_id=" . $app_id . "&redirect_uri=" . urlencode($redirect_url)
      . "&client_secret=" . $app_secret ."&grant_type=authorization_code". "&code=" . $code;
  /*

 
    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params); //parse name value pair
    */
	echo("<br><br>" );
	print_r(  $dados_post );
	return posta( $token_url, $dados_post );
 
     //echo ("<br><br>".  $token_url . "<br><br>");
    //return $params;
}


function posta($url, $dados_post){


 
$context = stream_context_create(
    array(
        'http' => array(
            'method' => 'POST',
            'header' => array(
                'Content-Type: application/x-www-form-urlencoded'),
            'content' => http_build_query($dados_post)
        )
    )
);
 
$result = file_get_contents(
    $url, false, $context);
	
	return $result;

}


?>