<?php
/**
 * Classe responsável por realizar operações com imagem
 *
 * @author Rodrigo Augusto Benedicto - 19/11/2014
 */
include 'lib/resize-class.php';

class ImageHelper
{
    //Variável que representa o complemento para o nome da imagem quando miniatura
    private $complementoMiniatura = "_mini";

    /*
     * @param $dir - diretório em que a imagem se encontra no servidor
     * @param $image_name - nome da imagem + extensão dentro do diretório
     * @param $width - nova largura desejada para a imagem
     * @param $miniature - se quiser gerar a extensão _mini no nome da imagem, com essa opção a função não sobreescreve a imagem original
     *
     * @return $name_final - nome em que a imagem foi salva no servidor
     */

    public function saveResizeImage($dir, $image_name, $width, $heigth,
                                    $miniature = false)
    {
        //Variável para o nome da imagem ao salvar no servidor
        $name_final = $image_name;

        //Instancia da classe responsável por redimensionar a imagem
        $resizeObj = new resize($dir.$image_name);

        //Verifica se é uma miniatura a ser gerada
        if ($miniature) {
            //Gera o nome da imagem com o complemento para miniatura
            $name_final = str_replace(".", $this->complementoMiniatura.".",
                $image_name);
        }

        //Redimensiona a imagem de acordo com os parâmetros passados
        if ($heigth != null && $width != null) {
            $resizeObj->resizeImage($width, $heigth, 'auto');
        } else if ($width != null) {
            $resizeObj->resizeImage($width, 0, 'landscape');
        } else if ($heigth != null) {
            $resizeObj->resizeImage(0, $heigth, 'portrait');
        }

        //Salva a imagem com a qualidade de 100%
        $resizeObj->saveImage($dir.$name_final, 100);

        return $name_final;
    }
}
?>
