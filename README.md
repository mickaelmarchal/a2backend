a2backend
=========

Symfony REST Backend for [a2proto](https://github.com/mickaelmarchal/a2proto) - Angular2 prototype.

1. Install docker and use `docker-compose up -d` to start
2. Connect to container with `docker-compose run apache-php bash`
3. `cd a2backend`
4. `composer install`
5. `php bin/console doctrine:database:create`
6. `php bin/console doctrine:schema:create`
7. go to [https://localhost](https://localhost) to run



