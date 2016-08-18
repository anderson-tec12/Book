<?php

/**
 * Classe responsável por realizar upload de arquivos para o servidor
 *
 * @author Rodrigo Augusto Benedicto - 17/11/2014
 */
class Upload {
    // Constante responsável por guardar a pasta de onde os arquivos estarão.

    const _FOLDER_DIR = "../files/templates/";

    // Método construtor que recebe o array com os arquivos via POST
    function __construct($curFile) {
        // Verifica se já existe diretório, caso não; é criado.
        if (!file_exists(self::_FOLDER_DIR)) {
            mkdir(self::_FOLDER_DIR);
        }
        $this->_file = $curFile;
    }

    //Método responsável por realizar a upload do arquivo
    function makeUpload() {

        //Verificar se existe arquivo;
        if (isset($this->_file)) {
            //Setar nome aleatório para evitar repetição e substiuição de arquivos;
            $randomName = uniqid();
            //Cria nome de arquivo concatenando DIRETÓRIO + NOME ALEATÓRIO + NOME DO ARQUIVO ENVIADO.

            $array = explode(".", $this->_file["name"]);
            $extensao = end($array);

            $fileName = $randomName . "." . $extensao;

            //Verifica se o arquivo foi realizado o upload
            if (is_uploaded_file($this->_file["tmp_name"])) {
                //Move o arquivo para o diretório escolhido, inserido na concatenação realizada.
                if (move_uploaded_file($this->_file["tmp_name"], self::_FOLDER_DIR . $fileName)) {
                    //Retorna true em casos de upload com sucesso 
                    return $fileName;
                } else {
                    //Retorna false com erro.
                    return "";
                }
            }
        }
    }

}

?>
