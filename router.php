<?php

$matches = [];

if( preg_match('/\/([^\/]+)\/([^\/]+)/' , $_SERVER['REQUEST_URI'], $matches) ){
    //El primer recurso que hace match con la expresión regular siempre es un espacio en blanco y ocupa la llave 0
    $_GET['resource_type'] = $matches[1];
    $_GET['resource_id'] = $matches[2];

    error_log( print_r($matches, 1) );
    require 'REST-SERVER.php';
}else if( preg_match('/\/([^\/]+)\/?/' , $_SERVER['REQUEST_URI'], $matches) ){
    //El primer recurso que hace match con la expresión regular siempre es un espacio en blanco y ocupa la llave 0
    $_GET['resource_type'] = $matches[1];

    error_log( print_r($matches, 1) );
    require 'REST-SERVER.php';
}else {
    error_log('No matches');
    http_response_code(404);
}