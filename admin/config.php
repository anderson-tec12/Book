<?php
//-------------------- POSTGRESQL -----------------------------
//echo(urldecode("http%3A%2F%2Fdesenvolvimento.possivelacordo.com.br%2Fsistema%2Flogin%2Fverifica.php%3Fcod%3D%257Bcodigo_verificacao%257D-15%26em%3Drodrigo%40loopes.com.br%26tp%3Dconvite"));


$G_ENCODING = "LATIN1";
$G_ENCODING = "UTF-8";

define("pg_host","179.188.16.113");
define("pg_port","5432");
define("pg_database","zioncloud3");
define("pg_user","zioncloud3");
define("pg_pass","amesma2016");
define("pg_schema","public");
define("pg_initialcommand","SET NAMES '".$G_ENCODING."'; SET CLIENT_ENCODING TO '".$G_ENCODING."'; ");
define("pg_client_encoding",$G_ENCODING);
///abc123A

define("K_DOMINIO", "http://itapoty.hospedagemdesites.ws/");
define("url_base","http://localhost:84/http://localhost:84/julio_itapoty/");
define("url_portal","http://localhost:84/julio_possivelacordo_git/possivel-acordo/");
//define("K_DIR","http://localhost:84/julio_possivelacordo_git/possivel-acordo/sistema");
//-------------------------------------------------------------
define("url_files","/sistema/files/");

//define("pg_client_encoding","LATIN1");

define("K_PAG_MINIMUN",15);
define("K_APP","sistema");

define("K_MSG_OBR","Campos obrigatórios *");

define("K_VIRTUALPATH_LOGO","/julio_possivelacordo_git/possivel-acordo/sistema/");

define("K_VERSAO","versão 1.0");


define("K_CONN_TYPE","postgres");
define("K_URL_PAINEL","index.php");

$mostrarBotaoExportar = false;


define("K_HEIGHT_REDUCAO_FIN", 80);

define("K_JOOMLABASE", "D:\\OpenServers\\apache_php5\\www\\julio_possivelacordo_git\\possivel-acordo\\portal");

define("K_TIPOLOGIN","postgres");

$conexao_joomla = array("server"=>"rafaeldatabase",
          "port"=>"3306", "user"=>"root", "password"=>"", "database"=>"possivel_portal",
         "tabela_usuario"=>"rijum_users");

//----------------- MYSQL ----------------------------------
define("mysql_host", $conexao_joomla["server"] );
define("mysql_port", $conexao_joomla["port"] );
define("mysql_db", $conexao_joomla["database"] );
define("mysql_user", $conexao_joomla["user"]  );
define("mysql_pass" , $conexao_joomla["password"]  );

//Mapa...
define("K_MAP_IMAGE", "maps.jpg");
define("K_MAP_IMAGE_HEIGHT", 1594);
define("K_MAP_IMAGE_WIDTH", 2500);
define("K_MAP_IMAGE_ZOOM", 0.5);



//define("pg_schema","sica");
define("mysql_initialcommand"," SET NAMES 'latin1' ");
//-------------------------------------------------------------
//"/home/possivel/public_html/sistema/"

//die(" --> ". __DIR__);

define("K_DIR", __DIR__ . DIRECTORY_SEPARATOR);
define("K_DIR_CUSTOM", K_DIR . "custom" . DIRECTORY_SEPARATOR);
define("K_DIR_PAINEL", K_DIR . "painel" . DIRECTORY_SEPARATOR);
define("K_DIR_LIBRARY", K_DIR . "library" . DIRECTORY_SEPARATOR);
define("K_DIR_MODULO", K_DIR_PAINEL . "modulos" . DIRECTORY_SEPARATOR);
define("K_DIR_COMPONENTE", K_DIR_PAINEL . "ferramentas" . DIRECTORY_SEPARATOR);

define("K_RAIZ","/sistema02/admin/");
define("K_RAIZ_DOMINIO","/sistema02/");


?>