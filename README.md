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