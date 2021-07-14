# Simple API Registry

This is a Simple API Registry.

## Instalation

```
cp .env.example .env
cp docker-compose.override.example.yml docker-compose.override.yml
docker-compose pull
docker-compose up -d
docker-compose exec workspace composer install
docker-compose exec newman sh -c "cd /var/www/html; npm install"
docker-compose down
docker-compose up -d
docker-compose exec workspace php artisan migrate:fresh
docker-compose exec workspace phpunit tests
```

## Using

Visit, for example:

- List of all providers
    - https://register.local/api/v1/providers

- Details of provider `example_provider`
    - https://register.local/api/v1/providers/example_provider/

- Definition of provider `example_provider`
    - https://register.local/api/v1/providers/example_provider.yaml

- URIs of provider `example_provider`
    - https://register.local/api/v1/providers/example_provider/uris

- Testing provider `example_provider` against all his consumers
    - https://register.local/api/v1/providers/example_provider/test

- List all consumers from provider `example_provider`
    - https://register.local/api/v1/providers/example_provider/consumers

- Details of consumer `example_consumer`
    - https://register.local/api/v1/providers/example_provider/consumers/example_consumer

- Test definition of consumer `example_consumer`
    - https://register.local/api/v1/providers/example_provider/consumers/example_consumer.json

- Testing consumer `example_consumer`
    - https://register.local/api/v1/providers/example_provider/consumers/example_consumer/test
