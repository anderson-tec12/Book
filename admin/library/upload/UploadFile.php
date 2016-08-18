<?php

/**
 * Classe responsável por realizar upload de arquivos para o servidor
 *
 * @author Rodrigo Augusto Benedicto - 17/11/2014
 */
class UploadFile {

    private $diretorio;
    private $nomeArquivoSalvo;
    
    public function __construct() {
        
    }

    //Função que realiza o envio da imagem para o servidor
    public function doUploadFile($file, $dir) {

        // Verifica se já existe diretório, caso não; é criado.
        if (!is_dir($dir)) {
            try {
                mkdir($dir);
            } catch (ErrorException $exception) {
                throw new Exception('Problema ao gerar diretório no servidor!' . $exception->getMessage());
            }
        }

        $this->diretorio = $dir;
        //Verificar se existe arquivo;
        if (isset($file)) {
            //Setar nome único para evitar repetição e substiuição de arquivos;
            $randomName = uniqid();
            //Pega a extensão do arquivo
            $arr = explode(".", $file["name"]);
            $extensao = end($arr);
            //Cria no nome com a extensão desejada
            $this->nomeArquivoSalvo = $randomName . "." . $extensao;
            //Verifica se o arquivo foi realizado o upload
            if (is_uploaded_file($file["tmp_name"])) {
                //Move o arquivo para o diretório escolhido, inserido na concatenação realizada.
                if (move_uploaded_file($file["tmp_name"],  $this->diretorio . $this->nomeArquivoSalvo)) {
                    //Retorna nome do arquivo em casos de upload com sucesso 
                    return true;
                } else {
                    throw new Exception('Problema ao mover arquivo no servidor!');
                }
            } else {
                throw new Exception('Problema ao realizar upload do arquivo para o servidor!');
            }
        } else {
            throw new Exception('Arquivo passado por parâmetro é nulo!');
        }
    }

    public function getNomeArquivoSalvo() {
        return $this->nomeArquivoSalvo;
    }

}

?>
