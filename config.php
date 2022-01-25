<?php
spl_autoload_register(function($clas_name){

    $fileName = "class". DIRECTORY_SEPARATOR .$clas_name.".php";

if(file_exists(($fileName))){
    require_once($fileName);
}

});