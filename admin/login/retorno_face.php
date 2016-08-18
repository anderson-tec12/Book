<?
require_once("config.php");

echo ("<h1>Retorno</h1>");

foreach ($_REQUEST as $key => $value){
   echo("<br><b>". $key ."</b> = " . $value );
}

$codigo = @$_GET["code"];

$arr_token = getAccessTokenDetails($id_facebook, $app_secret_facebook, $retorno_facebook , $codigo);

$token = $arr_token["access_token"];
$dados_do_cara = getUserDetails(  $token );

echo("<br><br>Token : ". $token);
echo("<br><b>Dados do cara</b><br>");
print_r($dados_do_cara);

function getUserDetails($access_token)
{
    $graph_url = "https://graph.facebook.com/me?access_token=". $access_token;
    $user = json_decode(file_get_contents($graph_url));
    if($user != null && isset($user->name))
        return $user;
 
    return null;
}
function getAccessTokenDetails($app_id,$app_secret,$redirect_url,$code)
{
 
    $token_url = "https://graph.facebook.com/oauth/access_token?"
      . "client_id=" . $app_id . "&redirect_uri=" . urlencode($redirect_url)
      . "&client_secret=" . $app_secret . "&code=" . $code;
 
    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params); //parse name value pair
 
    return $params;
}



?>