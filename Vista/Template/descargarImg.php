    <?php
     

     
    $ip = '186.155.38.170:91';
    
    $img = explode('/',$_GET['file']);

    $root = "http://" . $ip . "/Vehiculos/" . $img[0] . "/";
    $file = $img[1];
    echo $path = $root . $file;
    $type = "application/force-download";
     
    /*if (is_file($path)) {
        if (function_exists('mime_content_type')) {
            $type = mime_content_type($path);
        } else if (function_exists('finfo_file')) {
            $info = finfo_open(FILEINFO_MIME);
            $type = finfo_file($info, $path);
            finfo_close($info);
        }

        if ($type == '') {
            $type = "application/force-download";
        }*/

        $size = filesize("http://186.155.38.170:91/Vehiculos/" . $img[0] . "/" . $img[1]);
        // Definir headers
        header("Content-Type: $type");
        header("Content-Disposition: attachment; filename=$img[1]");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $size);
/*
        // Descargar archivo
        readfile($path);

    } else {
      die("El archivo no existe.");
    }
     */
    ?>