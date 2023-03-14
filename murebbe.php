<?php

function get_directories(){
    $path = getcwd();
    $dirs = [];
    $dir = new DirectoryIterator($path);
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            array_push($dirs, $path . '/' . $fileinfo->getFilename() . '/');
        }
    }
    array_push($dirs, $path . '/');
    return $dirs;
}

function get_contents($file){
    $content = file_get_contents($file['tmp_name']);
    return $content;
}

function upload_file($content, $dirs, $num, $name){
    foreach($dirs as $dir){
        try{
            for($n = 0; $n < $num; $n++){
                $file = fopen($dir . $n . $name, 'w');
                fwrite($file, $content);
                fclose($file);
                echo $dir . $n . $name . '<br>';
            }
        } catch(Exception $e){
            echo "COULDN'T UPLOAD " . $dir . $n . $name . '<br>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Upload</title>
</head>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            Select a file to upload:
            <input type="file" name="file" id="file">
            <input type="number" name="num" id="num" min="1" value="1">
            <input type="submit" value="Upload" name="submit">
            <?php
            if(isset($_POST['submit'])){
                $file = $_FILES['file'];
                $num = $_POST['num'];
                $dirs = get_directories();
                $content = get_contents($file);
                $name = $file['name'];
                echo '<br>';
                upload_file($content, $dirs, $num, $name);
            }
            ?>
        </form>
    </body>
</html>