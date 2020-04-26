#Docker
`Сбилдить`  и запустить в фоне:
```
sudo docker-compose up --build -d
```
`Запустить` docker-compose в фоне:
``` 
sudo docker-compose up -d
``` 
`Остановить` docker-compose:
```
sudo docker-compose down
```
`Запустить под докером комманду`:
```
sudo docker-compose exec php-cli some_command
```
Образец:
```
sudo docker-compose exec php-cli php artisan make:model Models\SomeModel
```

### Url
```
https://127.0.0.1:8080/
```

### База данных
в `.env` в корне сайта есть *DB_USERNAME* и *DB_PASSWORD* `127.0.0.1:33061`

###PhpMyAdmin
http://127.0.0.1:8081

###Swagger
http://127.0.0.1:8082
