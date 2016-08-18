<?php

session_start();

	 session_destroy();
	
$ont = "";

//if ( request("red") == "login" )
	//$ont = "?pag=login";
	
die("<script>top.location='index.php".$ont."';</script>");
		
		
?>		