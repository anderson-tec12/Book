<?

require_once("config.php");



   function curPageURL() {
 $pageURL = 'http';
 if (@$_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
   
   $url_login_face = "../oAuth/login_with_facebook.php";
   $url_login_google = "../oAuth/login_with_google.php";
   $url_login_microsoft = "../oAuth/login_with_microsoft.php";
   $url_login_twitter = "../oAuth/login_with_twitter.php";
   
   echo ("<br> Facebook retornará para a url: " .   $retorno_facebook );
   echo ("<br> Google retornará para a url: " .   $retorno_google );
   
?>
<style>
.botaoFace{
   background: #3F6F96;
   font-size: 16px;
   color: white;
   border: solid 1px #3F6F96;
   font-weight: bold;
   width: 140px;
 
}
.botaoGoogle{
   background-color: white;
   font-size: 16px;
   color: #96493F;
   border: solid 1px #96493F;
   font-weight: bold;
   width: 140px;
}

.botaoMS{
   background:white;
   font-size: 16px;
   color:  #3F6F96;
   border: solid 1px #3F6F96;
   font-weight: bold;
   width: 140px;
 
}
.botaoTw{
   background:#7EB3CD;
   font-size: 16px;
   color: white ;
   border: solid 1px  #7EB3CD;
   font-weight: bold;
   width: 140px;
 
}


</style>
<script>
function login( tipo ){
    if ( tipo == "face" ){
	        document.location='<?=$url_login_face?>';
	}

	if ( tipo == "google" ){
	        document.location='<?=$url_login_google?>';
	   
	} 
	
		if ( tipo == "ms" ){
	        document.location='<?=$url_login_microsoft?>';
	   
	} 
	
			if ( tipo == "twitter" ){
	        document.location='<?=$url_login_twitter?>';
	   
	} 
	
}

</script>
<table>
   <tr>
         <td>
              <input type="button" class="botaoFace" value="Login Facebook" onclick="login('face')" >
         </td>
    </tr>
<tr>	
		 
         <td>
              <input type="button" class="botaoGoogle" value="Login Google" onclick="login('google')"  >
         </td>
    </tr>
<tr>	
	 
         <td>
              <input type="button" class="botaoMS" value="Login Microsoft" onclick="login('ms')"  >
         </td>
   </tr>
   
   <tr>	
	 
         <td>
              <input type="button" class="botaoTw" value="Login Twitter" onclick="login('twitter')"  >
         </td>
   </tr>

</table>