
## Installation


```sh
docker-compose up -d
docker exec -it php-container composer install
docker exec -it php-container php bin/console doctrine:schema:create
```

### API:

Create ticket `GET http://127.0.0.1:8000/create-ticket/`

Make available ticket `GET http://127.0.0.1:8000/available-ticket/{id}`

Lock ticket `GET http://127.0.0.1:8000/lock-ticket/{id}`

Buy ticket `GET http://127.0.0.1:8000/pay-ticket/{id}`

Return ticket `GET http://127.0.0.1:8000/return-ticket/{id}`
