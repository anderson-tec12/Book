<?php
//class para ultilizar ftp
class ftp {
    public  $ftp_server = 'ip';
    public $login_ftp = 'user';
    public $pass_ftp = 'senha';
    public $id_ftp;
    private $ftp_port = 21;
    public $ftp_time = 90;
    public $ftp_contents;
    public $login_result;
    public $ftp_dir;
    public $copy;
    //public $local_file = "arquivo do meu site";
    //public $server_file = "arquivo do portal";
    public $delete_file;

 
   
    
    public function __construct($dir = "") {
        
    	$this->ftp_server =   constant("K_SERVERFTP");
             
             $this->ftp_port = constant("K_PORTFTP");
             $this->login_ftp = constant("K_USERFTP");
             $this->pass_ftp = constant("K_PASSFTP");
             if ($dir=="")
                 $this->ftp_dir  = constant("K_ROOTFOLDERFTP");
             else 
                $this->ftp_dir  = $dir;
        
		//Testando conexão com ssl security.    
		//$this->id_ftp = ftp_ssl_connect($this->ftp_server, $this->ftp_port,$this->ftp_time ) or die("Nao conectou ao ftp");
    	$this->id_ftp = ftp_connect($this->ftp_server,$this->ftp_port,$this->ftp_time) or die("Nao conectou ao ftp");
        if ($this->id_ftp) {
            //echo("sucesso<hr />");
            
                
            $this->setLogin();
        }
    }
    public function setLogin(){
    	//die($this->login_ftp);
    	
        $this->login_result = ftp_login($this->id_ftp, $this->login_ftp, $this->pass_ftp);
	    
		@ftp_pasv($this->id_ftp,TRUE);
	
		if($this->login_result){
           // $this->getlistFiles();
        }
    }
    public function getlistFiles($diretorio){
        $this->ftp_dir = ftp_chdir($this->id_ftp, $diretorio);//coloque o diretorio de origem dos arquivos
        $arr  = ftp_nlist($this->id_ftp,".");
       
        $this->ftp_contents = array();
        //die ( count($arr) );
        for ($i =0; $i< count($arr); $i++)
        {
        
            $dot = strchr($arr[$i],".");    
		
		    if ($dot)    
		    {
		      array_push($this->ftp_contents,$arr[$i]);
		    	
		    }
        }
        if ($this->ftp_contents) {
           // echo("<pre>");
            //print_r($this->ftp_contents);
         //   echo("</pre><pre>");
       //     $this->copyFiles();
        }
    }
    
    function ftp_is_dir($dir) {
		  
		 if (@ftp_chdir($this->id_ftp, $dir)) {
		    @ftp_chdir($this->id_ftp, '..');
		    return true;
		  } else {
		    return false;
		  }
    }

    
    public  function getListContent($dir, $tipo=1)
    {
	 //ftp_chdir($this->id_ftp, "./");
	 $diretorio = htmlspecialchars($dir); 
    // die ( $diretorio ) ;
	 if (  @ftp_chdir($this->id_ftp, str_replace("./","/", $diretorio) ) )
	  {
         $this->ftp_dir = @ftp_chdir($this->id_ftp, str_replace("./","/", $diretorio) );//diretorio de origem
      }
	  else
	  {
	      $this->ftp_dir = @ftp_chdir($this->id_ftp, str_replace("./","/", $dir) );//diretorio de origem

	  }
	  
     $arr  = ftp_nlist($this->id_ftp,".");
     
     
       
        $this->ftp_contents = array();
        
        //if ($tipo ==2)
		//   die ( count ( $arr )."eeeuuuu". $diretorio ) ;  
        
        for ($i =0; $i< count($arr); $i++)
        {
		
            if ($tipo==1)
               $dot = $this->ftp_is_dir($arr[$i]);   
			else 
	            $dot = !$this->ftp_is_dir($arr[$i]);   
	        
			if ( $tipo == 3 )
				$dot = true;
			     
			   	
		     if ($dot)    
		    {
			  
		    	if ($diretorio=="/")
		    	    $c = $arr[$i];
		    	else
		            $c = $diretorio."/".str_replace("./","",$arr[$i]);
		            
		    	
		      array_push(  $this->ftp_contents,  $c."|".$this->getName($arr[$i]));
		    }
			
        }
        sort($this->ftp_contents);
    
    }
    
    function getName($nome)
    {
    	$arr = explode("/",$nome);
    	
    	return $arr[count($arr)-1];
    }
    
    function upload($dir,$file_tmp_name,$file_name)
	{ 
	$arqLocal = $file_tmp_name;  //nome temporário do arquivo que o formulario enviou 

    //if ($arqLocal){ 
       // echo ($arqLocal ."09");
    
        $arqServidor = $file_name; //nome real do arquivo 
       
        ftp_chdir ($this->id_ftp, $dir);     //abre o diretorio para a copia 
		//  die (  htmlspecialchars( $dir)  );
		$uploadok = ftp_put($this->id_ftp, "$arqServidor", "$arqLocal", constant("K_TP_TRANSF") );  //copia o arquivo para o ftp 
        
		if ($uploadok) return 1; 
      
    //  } 
	}
	
	function download($local_file, $server_file )
	{
		ftp_get($this->id_ftp, $local_file, $server_file, FTP_ASCII);
		
	}
    
    
    public  function newFolder($dir)
    {
    	$d = htmlspecialchars($dir);
    	return  ftp_mkdir($this->id_ftp, $d);    	
    	
    	
   }
    
    
	function delDir($dir)
	{
	   //conecta();
	    return  @ftp_rmdir($this->id_ftp, $dir);
	 //desconecta();
	} 

	function delArquivo($file)
	{
	
	    return @ftp_delete($this->id_ftp, $file);

	}
	
    public function copyFiles(){
        for($i=0;$i<count ($this->ftp_contents);$i++){
            $this->copy = ftp_nb_get($this->id_ftp, "diretorio de destino dos arquivos".$this->ftp_contents[$i], $this->ftp_contents[$i], FTP_BINARY);
            while ($this->copy == FTP_MOREDATA) {
                echo ".";
                $this->copy = ftp_nb_continue($this->id_ftp);
            }
            if ($this->copy != FTP_FINISHED) {
                echo "There was an error downloading the file...";
            }else{
                $this->delete_file = ftp_delete($this->id_ftp, $this->ftp_contents[$i]);
                if($this->delete_file){
                    echo("File deleting");
                }
            }
        }
    }
    public function __destruct(){
        ftp_close($this->id_ftp);
    }
}
?>
