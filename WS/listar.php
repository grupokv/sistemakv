<?php
function listar_archivos($directorio){                                               
       
    $puntos = array('.', '..'); // exluimos.                       
    $item = array_diff(scandir($directorio), $puntos);
       
    natsort($item);

    foreach($item as $archivo) {
                                   
        $ruta = $directorio.$archivo;
        
        if (is_dir($ruta)){
           //solo si el archivo es un directorio, distinto que "." y ".."
           $info = pathinfo($archivo);
           echo "<ul><li><span class=\"folder\">".$info['filename']."</span>";
                        
           //echo '<li><a href="'.$ruta.'">'.$info["filename"].'</a></li>';
           listar_archivos($ruta."/");

           echo "</li></ul>";
        }

        if (is_file($ruta)) {      
           
            $info = pathinfo($archivo);
            echo '<li><a href="'.$ruta.'">'.$info["filename"].'</a></li>';
        }                      
    }; 
}
    
    echo "<ul id=\"browser\" class=\"filetree treeview-famfamfam\">";  
    listar_archivos("../"); 
    echo "</ul>";
  
?>