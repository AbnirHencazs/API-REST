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

## *Auth HTTP*

`$ curl http://mauro:12345@localhost:8001/books`

Autenticacion HTTP, no es la más segura puesto que la información del usuario viaja publicamente

## *Auth HMAC*

Para usar la autenticación HMAC es necesario pasar en los encabezados de la solicitud un hash, un id de usuario y una etiqueta de tiempo. Para generar el hash y la etiqueta de tiempo puedes correr el siguiente script pasandole el id de usuario como parametro:

`$ php generate_has.php 1`

Una vez obtenido los datos, procedemos a incluirlos en los _headers_ de la solicitud: 

`$ curl http://localhost:8001/books -H 'X_HASH: e4241ba1c7652e83ffd2ba4ababe8397d5f57c0d' -H 'X-UID: 1' -H 'X-TIMESTAMP: 1611590461'`

Éste tipo de autenticación es de las más seguras

## *Auth Access tokens*

Para usar la autenticación vía access tokens es necesario agregar un servidor de autenticación _separado_ del servidor de recursos, la función de dicho servidor será la de aceptar solicitudes POST para otorgar un token al cliente y por otro lado aceptar solicitudes GET, de parte del servidor de recursos, para corroborar que en efecto el token del cliente es valido.

Para correr el servidor de autenticación simplemente correr éste script (en un puerto diferente al servidor de recursos):

`$ php -S localhost:8002 auth_server.php`

Para obtener _el_ token de acceso es necesario hacer una solicitud donde pasemos el user id y el secreto por los headers:

`$ curl http://localhost:8002 -X 'POST' -H 'X-Client-Id: 1' -H 'X-Secret:SecretoDeEstado'`

Para obtener acceso a los recursos es necesario hacer una solicitud donde pasemos _el_ token por los headers:

`$ curl http://localhost:8001/books -H 'X-Token: 5d0937455b6744.68357201'`