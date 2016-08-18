<?php

include_once 'UploadFile.php';
/*
 * Classe responsável por realizar upload de imagens
 * 
 * @author Rodrigo Augusto Benedicto - 18/11/2014
 */

class UploadDocPdf {

    private $uploadFile;
    private $tipoValidos = array("application/pdf","application/vnd.openxmlformats-officedocument.wordprocessingml.document");

    public function __construct() {
        $this->uploadFile = new UploadFile();
    }

    //Função que realiza o envio da imagem para o servidor
    public function doUploadFile($file, $dir) {

        //Caso necessite implementar filtro ou tratamento de imagens
        $typeFile = $file['type'];

        if (array_search($typeFile, $this->tipoValidos) === false) {
            throw new Exception("Formato Inválido");
        }

        $this->uploadFile->doUploadFile($file, $dir);

        //Retorna o nome do arquivo salvo no servidor
        return $this->uploadFile->getNomeArquivoSalvo();
    }

}

?>
