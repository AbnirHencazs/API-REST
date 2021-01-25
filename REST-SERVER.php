<?php

//Buscamos la autenticación en los encabezados HTTP
/*
$user = array_key_exists( 'PHP_AUTH_USER', $_SERVER ) ? $_SERVER['PHP_AUTH_USER'] : '' ;
$pwd = array_key_exists( 'PHP_AUTH_PW', $_SERVER ) ? $_SERVER['PHP_AUTH_PW'] : '' ;

if( $user !== 'mauro' || $pwd !== '12345'){

    die;
}*/

//Autenticaciónm HMAC
//Verfico que la información recibida tenga un hash, una marca de tiempo y el id del usuario
if(
    !array_key_exists('HTTP_X_HASH', $_SERVER) ||
    !array_key_exists('HTTP_X_TIMESTAMP', $_SERVER) ||
    !array_key_exists('HTTP_X_UID', $_SERVER)
){
    die;
}

list( $hash, $uid, $timestamp ) = [
    $_SERVER['HTTP_X_HASH'],
    $_SERVER['HTTP_X_UID'],
    $_SERVER['HTTP_X_TIMESTAMP']
]; //Armamos un arreglo para guardar las variables del servidor en variables locales

//Secreto que solo deberían tener el cliente y el servidor
$secret = 'Esto es un secreto';

//Funcion de hash conocida por el cliente y servidor
$newHash = sha1($uid.$timestamp.$secret);//concatenamos la informacion

//comparamos si ambops hashes son iguales para autorizar acceso
if( $newHash !== $hash){
    die; //No autorizamos acceso a los recursos
}

//Definimos los recursos disponibles
$allowedResourceType = [
    'books',
    'authors',
    'genres'
];

//Validamos que el recurso éste disponible
$resourceType = $_GET['resource_type'];

if( !in_array($resourceType, $allowedResourceType) ){

    die;
}

//Definimos los recursos
$books = [
    1 => [
        'title' => 'Gone with the wind',
        'id_author' => 2,
        'id_genre' => 2
    ],
    2 => [
        'title' => 'La Iliada',
        'id_author' => 345,
        'id_genre' => 50
    ],
    3 => [
        'title' => 'La odisea',
        'id_author' => 123,
        'id_genre' => 50
    ]
];

header('Content-type: application/json');

//Si se pide un recurso en especifico, validaremos su existencia
$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';

//Generamos la respuesta asumiendo que el pedido es correcto
switch (strtoupper( $_SERVER['REQUEST_METHOD'] )) {
    case 'GET':
        if( empty($resourceId) ){
            echo json_encode($books);
        } else {
            if( array_key_exists( $resourceId, $books ) ){
                echo json_encode( $books[$resourceId] );
            }
        }
        break;
    case 'POST':
        $json = file_get_contents('php://input'); //Para acceder la variable $_POST en crudo
        $books[] = json_decode( $json, true );//Transformamos el json recibido a un nuevo elemento en el arreglo

        echo json_encode($books);//Emitimos la respuesta
        break;
    case 'PUT':
        //Validamos que el recurso buscado exista
        if( !empty($resourceId) && array_key_exists($resourceId, $books) ){
            $json = file_get_contents('php://input');
            $books[$resourceId] = json_decode($json, true);

            echo json_encode($books);
        }
        break;
    case 'DELETE':
        // Validamos que el recurso exista
        if( !empty($resourceId) && array_key_exists($resourceId, $books) ){
            unset( $books[$resourceId] ); //Eliminamos del arreglo books

            echo json_encode($books);
        }
        break;
    default:
        # code...
        break;
}