<?php

/* TODO: Add code here */

class UfcController extends Zend_Controller_Action
{
	
	public function loadVars(){
		
		
		$acao = $this->_request->getParam("acao");
		$this->view->acao = $acao;
		
		
		$this->view->parametros = $this->_getAllParams();
		//$this->view->parametros = $parametros;
		
		
		
		$this->view->request = $this->_request;
		
		
		$this->view->pesquisar = Util::NVL($this->_request->getParam("pesquisar"),0);
		$this->view->tipo = Util::NVL($this->_request->getParam("tipo"),1);	
		
		
		$this->view->ispostback = Util::NVL($this->_request->getParam("ispostback"),0);
		$this->_ispostback = Util::NVL($this->_request->getParam("ispostback"),0);
		
		$this->view->helper = $this->_helper;
		 
	}	
	
	public function getNumeroParam($valor){
		
		return Util::numeroBanco( $this->_request->getParam(	$valor ));
	}
	
	public function __construct(Zend_Controller_Request_Abstract $request, 
		Zend_Controller_Response_Abstract $response, 
		array $invokeArgs = array())
	{
		$controller =  $request->get("controller");
		$view =  $request->get("view");
		$module =  $request->get("module");
		
			
		
		
		parent::__construct( $request, $response, $invokeArgs);
		
		$arr = array("controller"=>$controller,
				"view"=>$view,
				"module"=>$module);
		
		$this->view->DadosUrl = $arr;	
		
		//return; //Tirar isso daqui para quando o login estiver ok.
		if ( strtolower( $controller ) == "login"
				|| strtolower( $controller ) == "pagamentospp"){
			
			
		}else {
			
			
			//Se o camarada não está logado, voltaremos para a tela de login..
			if ( ! SessionFacade::usuarioLogado() ){
				
				//$_SESSION["st_login"] = "Seu login expirou. Por favor entre novamente no sistema!";
				
				$this->_helper->redirector('login', 'index', 'app');
			}
		}
		
		$popup = $request->getParam("popup");
		
		if ( $popup == 1 ){
			
			$this->_helper->layout->setLayout('branco');	
		}
	}
	
	
	
	public function campoFiltro($campo, $coluna = "",$leftSinal="", $rightSinal="", $sinal = " = ", $data = false){
		
		if ( $coluna == "" )
			$coluna = $campo;
		
		if ( !$data ){	
			if ( $this->_request->getParam($campo) != "" )			
				return " and ". $coluna . " ".$sinal." " .$leftSinal. $this->_request->getParam($campo).$rightSinal;	
			
			
		} else {
			
			if ( $this->_request->getParam($campo) != "" )			
				return " and ". $coluna . " ".$sinal." " .$leftSinal. Util::dataPg( $this->_request->getParam($campo)).$rightSinal;	
			
			
		}
		
		return "";
	}
	
	
}
?>