<?php
// Create a blank image and add some text
require_once("admin/config.php");

$X = @$_GET["X"];
$Y = @$_GET["Y"];

if ( $X != "" && $Y != "" ){
$ini_filename = realpath(".") . DIRECTORY_SEPARATOR . "img". DIRECTORY_SEPARATOR . "". K_MAP_IMAGE;
$im = imagecreatefromjpeg($ini_filename );

 $size = getimagesize($ini_filename );

 $image_x_size = $size[0];
 $image_y_size = $size[1];

//$ini_x_size = getimagesize($ini_filename )[0];
//$ini_y_size = getimagesize($ini_filename )[1];

//the minimum of xlength and ylength to crop.
//$crop_measure = min($ini_x_size, $ini_y_size);

// Set the content type header - in this case image/jpeg

$tamanhoPolygono = 12;
$size_x = 500; $size_y = 138; $difPontoX = 0; $difPontoY = 0;


setaIndiceMaximo($X, $image_x_size, ($size_x/2), $difPontoX);
$posicao_inicial_x = $X - ($size_x/2) + $difPontoX;

setaIndiceMaximo($Y, $image_y_size, ($size_y/2), $difPontoY);

$posicao_inicial_y = $Y - ($size_y/2) + $difPontoY;

$centroX = ($size_x/2)-($tamanhoPolygono/2)  - $difPontoX;
$centroY = ($size_y/2)-($tamanhoPolygono/2) -  $difPontoY;

//echo("<br>Calculando o X - Tamanho Máximo: " . $image_x_size. " , Posição: " . $X . " , Pedaço: ". ($size_x/2) );
//  echo("<br>Diferenças: " . $difPontoX . " / Y: ".  $difPontoY. "Ponto do Centro X ". $centroX . " Ponto do Centro Y ". $centroY. "<br>");
$to_crop_array = array('x' =>$posicao_inicial_x , 'y' => $posicao_inicial_y, 'width' => $size_x, 'height'=> $size_y);
$thumb_im = crop($ini_filename, $im, $to_crop_array, $centroX, $centroY);

header('Content-Type: image/jpeg');
imagejpeg($thumb_im);

}

function setaIndiceMaximo( $pos, $tamMaximo, $pedaco, &$diferenca ){
        global $tamanhoPolygono;
    if ( $pos + $pedaco  > $tamMaximo ){
        
        $diferenca =  $tamMaximo - ($pos + $pedaco); 
    }
     if ( $pos - $pedaco < 0  ){
         
        $diferenca = abs(   $pos - $pedaco );
         
     }
}

function crop($ini_filename, $im, array $options, $centroX, $centroY ){
    global $tamanhoPolygono;
    
    $size = getimagesize($ini_filename );
    
     $imageCroped = imagecreatetruecolor($options["width"], $options["height"]); 
                imagecopy($imageCroped, $im, 0, 0, $options["x"],
                        $options["y"], $size[0], $size[1]);    
    
     $col_ellipse = imagecolorallocate($imageCroped, 148, 69, 43);

      // desenha o elipse branco
        imagefilledellipse($imageCroped, $centroX, $centroY, $tamanhoPolygono, $tamanhoPolygono, $col_ellipse);
                
                return $imageCroped;

}
?>