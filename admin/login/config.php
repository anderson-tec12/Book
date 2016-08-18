<?

  $id_facebook = "1601829166710207";
  $app_secret_facebook = "6ee73becc91e2978a5bd4082c7865236";
  
  $id_google = "726481506776-dd3073embadleplbvlgt603j1j88ejtr.apps.googleusercontent.com";
  $email_address_google = "726481506776-dd3073embadleplbvlgt603j1j88ejtr@developer.gserviceaccount.com";
  $google_secrets = "6ZFW8aqKOUYAkYOdkp9NLode";
  
  


  $retorno_facebook = "http://rendti.com.br/logins_teste/retorno_face.php";
   $url_login_face = "https://www.facebook.com/dialog/oauth?client_id=". $id_facebook."&redirect_uri=".   $retorno_facebook;
   
   
   
  $retorno_google = "http://rendti.com.br/logins_teste/retorno_google.php";


  $url_login_google = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=".
  $id_google."&redirect_uri=".$retorno_google.
   "&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email";
  
  
  $url_final_retorno = "";
  
  ?>