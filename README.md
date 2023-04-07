### Description:
Very simple wallet implementation using PHP8.2, Symfony, DDD, hexagonal architecture, prooph. No rest api yet,
just command line scripts testing proof of concept.

### What works:
* CQRS (based on Symfony messenger)
* event store (prooph)
* one aggregate with one entity
* assertions
* three commands (create wallet, deposit, withdraw)
* multiple currencies supported

### What should be done next:
* rest api endpoints
* more tests
* snapshots
* currency and owner id as value objects
* more assertions
* projections

### Run:
```
composer install --ignore-platform-reqs
docker-compose up
docker exec -it proof_php_1 /bin/bash
php bin/console doctrine:migrations:migrate
```

### Demo:
```
php bin/console app:demo:1
php bin/console app:demo:2
```

### Unit tests:
```
vendor/bin/phpunit tests/Unit
```

### Code analysis:
```
vendor/bin/phpcs src
vendor/bin/psalm src
```
