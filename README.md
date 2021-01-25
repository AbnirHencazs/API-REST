## Server startup

Es necesario tener definida la variable de entorno PHP para poder usarla en la línea de comando 

`$ php -S localhost:8000 router.php`

Para iniciar el servidor en la ruta _localhost_ puerto _8000_, se puede usar cualquier puerto. Éste servidor solo funciona localmente por lo que las *solicitudes externas*, aunque sean de la misma LAN, no obtendrán respuesta

## *GET*
`$ curl http://localhost:8001/books` 

Para obtener todos los recursos

`$ curl http://localhost:8001/books/1` 

Para obtener recurso especifico

## *POST*
`$ curl -X 'POST' http://localhost:8000/books/1 -d '{ "title": "Day of reckoning", "id_author": 724, "id_genre": 34 }'` 

Para grabar un recurso

## *PUT*
`$ curl -X 'PUT' http://localhost:8001/books/1 -d '{ "title": "Day of reckoning", "id_author": 725, "id_genre": 34 }'`

Para reemplazar un recurso

## *DELETE*
`$ curl -X 'DELETE' http://localhost:8001/books/1` 

Para eliminar un recurso