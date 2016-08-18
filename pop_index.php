<?

session_start();

require_once("admin/library/Util.php");
require_once("admin/library/SessionFacade.php");
//require_once("admin/library/SessionCliente.php");
require_once("admin/oAuth/config.php");
require_once("admin/config.php");
require_once("admin/persist/IDbPersist.php");
require_once("admin/persist/connAccess.php");
require_once("admin/persist/FactoryConn.php");
require_once("admin/inc_usuario.php");


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Protetores da Cuesta</title>

	<!-- Biblioteca jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

	<!-- Font -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

	<!-- CSS -->
	<link rel="stylesheet" href="css/base.min.css">
	<link rel="stylesheet" href="css/reset.min.css">
	<link rel="stylesheet" href="css/main.min.css">
	<link rel="stylesheet" href="css/alert-custom.min.css">


    <link href="<?= K_RAIZ ?>javascript/jquery/style/jquery.ui.css" rel="stylesheet" type="text/css">
    <link href="<?= K_RAIZ ?>javascript/jquery/style/jquery.ui.ext.css" rel="stylesheet" type="text/css" >
    <link href="<?= K_RAIZ ?>javascript/jquery/jquery-ui-1.9.2.custom/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css">
</head>

<body>
<!-- JS -->
<?

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

 //print_r( $_POST );
$char_set = "uft-8";

$center_include = Util::request("cnt");
$pag = Util::request("pag");
$exact = Util::request("xct");
$comp = Util::request("comp");
$mod = Util::request("mod");

$sub = "";

function fn_write($data) {

    return $data;
}

function request($data) {

    return Util::request($data);

    return utf8_decode(Util::request($data));
}




 $file_to_include = "";


                            if ($pag != "") {

                                $file_teste = $sub . "pop_" . $pag . ".php";

                                if ($exact) {
                                    $file_teste = $sub . "" . $pag . ".php";
                                }


                                if (file_exists(realpath(".") . DIRECTORY_SEPARATOR . $file_teste)) {
                                    $file_to_include = $file_teste;
                                } else {
                                    echo 'Nao Encontrado path = ' . realpath(".") . DIRECTORY_SEPARATOR . $file_teste;
                                }
                            }
                            if ($file_to_include != "") {
                                require_once ( $file_to_include );
                            }

?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/jquery/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/jquery/jquery.click-calendario-1.0.js"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/jquery/query.datepick-pt-BR.js"></script>

<script src="js/modal-jquery-colorbox.js"></script>
<script src="js/alert-custom.js"></script>
<script src="js/dragdealer.js"></script>
<script src="js/script.js"></script>

<script type="text/javascript">
	// Modal
	$(document).ready(function () {
		$(".iframe-modal").colorbox({iframe: true, innerWidth: 980, height: "85%"});
		$(".iframe-modal-small").colorbox({iframe: true, innerWidth: 490, innerHeight: 500});
	});
</script>

</body>
</html>
<?  $oConn->disconnect(); ?>