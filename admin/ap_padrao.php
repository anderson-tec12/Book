<?php
//header("Content-Type: text/html; charset=ISO-8859-1", true);
//header("X-XSS-Protection: 0");

require_once("library/ArrayList.php");

session_start();

require_once("config.php"); 
require_once("library/Util.php");
require_once("library/ArrayList.php");
require_once("library/SessionFacade.php");
require_once("library/paginacao.php");
require_once("library/ucBotoes.php");


function request($nome, $trataInject = 1)
{
	return  Util::request($nome,$trataInject) ;
}



function numeroBanco($valor)
{
	$val = str_replace(".","",$valor);
	$val = str_replace(",",".",$val);
	
	return $val;
}
function numeroTela($valor, $removeZeros=1)
{
	if ($valor == null || $valor =="")
		return "";
	
	$val = number_format($valor,2,",",".");
	
	// $val = str_replace(".",",",$valor);
	if ( $removeZeros )
	{
		$val = str_replace(",00","",$val);
		for ( $i =1 ; $i <= 9; $i++)
		{
			$val = str_replace(",".$i."0",",".$i,$val);
			
		}
		
	}
	return $val;
}

function isAdm()
{
    if (  trim( strtolower( @$_SESSION["_Administrador"])) == "t")
	    return true;
		
	return false;
}

function NVL($val,$val2)
{
	//die ($val);
	
	return Util::NVL($val,$val2);
}

function left($string,$count) {
	$string = substr($string,0,$count);
	return $string;
}

function right($string,$count) {
	$string = substr($string, -$count, $count);
	return $string;
}


function getIdLogado()
{
	if (! isset($_SESSION["_Id"]))
		return null;
	
	return  $_SESSION["_Id"];
}

function hasPasta($lista, $pasta, $tolerancia = 0)
{
	$arr = explode(",",$lista);
	
	for ($z=0; $z < count($arr); $z++)
	{
		if ($pasta == $arr[$z])
		{
			return true;
		} 
		
		
		if ($tolerancia > 1)
		{
			
			if ( strlen($pasta) >= strlen($arr[$z]) && substr($pasta, 0, strlen($arr[$z]) ) ==$arr[$z] )
			{
				return true;
			}
		}
		
		else if ($tolerancia > 0)
			{
				
				if ( strlen($arr[$z]) >= strlen($pasta) && 
						substr($arr[$z], 0, strlen( $pasta ) ) ==$pasta )
				{
					
					return true;
				}
			}
	}
	
	return 0;
}

function getUserPasta()
{
	if (empty($_SESSION["_Pasta"]))
		return null;
	
	return $_SESSION["_Pasta"];
	
	
}

function getUserNome()
{
	if (empty($_SESSION["_Nome"]))
		return null;
	
	return $_SESSION["_Nome"];
	
	
}

function IdAdm()
{
	return constant("K_ADM");
}

function getTipoUsuarioId()
{
	if (empty($_SESSION["_TipoUsuarioId"]))
		return null;
	
	return $_SESSION["_TipoUsuarioId"];
	
}


function getPodeUpload()
{
	if (empty($_SESSION["_PodeUpload"]))
		return null;
	
	return $_SESSION["_PodeUpload"]; 	
}

function getPodeDownload()
{
	if (empty($_SESSION["_PodeDownload"]))
		return null;
	
	return $_SESSION["_PodeDownload"];
	
}

function estaLogado(){

    return @$_SESSION["_Id"];
}

//die ($_GET["checkLogin"] .  request("checkLogin")  );
if (Util::getGET("checkLogin") == "" && Util::getGET("checkLogin") != "0")
{
	//echo ($_SESSION["_Id"]);
	//die ( $_SESSION["Id"] ."<<<<<" . $G_KAPP );
	if (! estaLogado() )
	{
	//	die("<script>top.location='".$G_KAPP ."/login.php';</ script>");
	}
	
}


function getTituloModulo($mod, $ent, $tipo = "", $retornaTudo = 1 ){

    $entidade = "Projeto";
	$modelo = "Lista - ";
	
        
	if ( $mod == "adm" )
	    $modelo = "Administrar - ";
        
	if ( $mod == "cad" )
	    $modelo = "Cadastro - ";
		
	
	if ( $mod == "graf" )
		$modelo = "Gráfico - ";

	
	if ( $ent == "arquivo_cliente" )
		$entidade = "Documentos / Cliente";	

    if ( $ent == "usuario" )
	   $entidade = "Acesso (Usuário de acesso)";
	   
	  
    if ( $ent == "categoria" )
	   $entidade = "Categorias para o Check List";
	
    if ( $ent == "financeiro" )
	   $entidade = "Transações";
	
	if ( $ent == "clienteunidade"  && $tipo == 1 )
		$entidade = "Cliente / Unidades";
		
	
	if ( $ent == "clienteunidade"  && $tipo == 2 )
		$entidade = "Categorias";
	   
	   
    if ( $ent == "nutricionista" )
	   $entidade = "Profissional Controlare";
	
	
	if ( $ent == "inspecao" )
		$entidade = "Auditoria Técnica";
	
	
	if ( $ent == "peso" )
		$entidade = "Tabela de Pesos";
		
	
	if ( $ent == "estabelecimento" )
		$entidade = "Unidade";
		
	
	if ( $ent == "cliente" )
		$entidade = "Cliente / Estabelecimento";
	  
	
	if ( $ent == "modelo_checklist" )
		$entidade = "Check List";
	  
	
	
    if ( $ent == "cadastro_basico" && $tipo == 4 )   
	    $entidade =  "Funções dos Profissionais";
			
			
    if ( $ent == "cadastro_basico" && $tipo == 3 )   
	    $entidade =  "Finalidades dos Check List";
    
    
    if ( $ent == "cadastro_basico" && $tipo == 13 )   
	    $entidade =  "Email / Financeiro";
		
		
	if ( $ent == "cadastro_basico" && $tipo == 2 )   
		$entidade =  "Itens do Check List";
			
		
    if ( $ent == "cadastro_basico" && $tipo == 1 )   
	    $entidade =  "Perfil de Acesso";
		
	if ( $ent == "relatorio" && $tipo == 1 )  { 
		$entidade =  "Visita Técnica";
		
		$modelo = "Relatório - ";
	}


	if ( $ent == "relatorio" && $tipo == 2 )  { 
		$entidade =  "Inspeção em controle de validade - Produtos sem identificação";
		
		$modelo = "";
	}

	if ( $ent == "grafico"  )  { 
		$entidade =  "Gráficos";
		
		$modelo = "";
	}


	  if ( $retornaTudo )
         return $modelo . $entidade;
		 
	return $entidade;	 
}


function mostraDadosServidor(){
	
	//$linha_query = $_SESSION[SessionFacade::nomeSchema(). "_linha_query"];
	
	//$arp = explode("\t",$linha_query);
	
        $arp = array(pg_host);
    
	echo( SessionFacade::getProp("login")." - " . 	$arp[0]);
	
}

function getConexoesList(){
           
	$txt = ""; 
	$sep = "\\";
	
	$windows = true;
	
	if (stristr( PHP_OS, 'WIN')) { 
		$windows = true;
	} else { 
		$windows = false;
		$sep = "/";
	}
	if ( file_exists( realpath( "../") . $sep. "conexoes.txt" )){
		
		$txt = Util::lerArquivo( realpath( "../") . $sep. "conexoes.txt");	
	}
	
	
	if ( file_exists( realpath( ".") . $sep."conexoes.txt" )){
		
		$txt = Util::lerArquivo( realpath( ".") . $sep. "conexoes.txt");	
	}
	$arps = explode("\n", utf8_decode( $txt)  );
	
	//echo ( $txt . " --- " . realpath( ".")  );
	$ls_saida = array();
	
	//print_r( $arps);
	for ( $y = 0; $y < count($arps); $y++){
	          
		if ( trim( $arps[$y] ) == "" )
			continue;	
		
		if (  strpos(" ". trim( $arps[$y] ), "#"  ) )
			continue;
			
		$ls_saida[ count($ls_saida) ] = trim( $arps[$y] );
	}
	return $ls_saida;
	
}