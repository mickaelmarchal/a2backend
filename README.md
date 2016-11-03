a2backend
=========

Symfony REST Backend for [a2proto](https://github.com/mickaelmarchal/a2proto) - Angular2 prototype.

1. Install docker and use `docker-compose up -d` to start
2. Make sure you have a folder `../data/a2backend/log`
3. Connect to container with `docker-compose run apache-php bash`
4. `cd a2backend`
5. `composer install` -- for db credentials, use:
   - host: `mysql`
   - port: `3306`
   - username: `root`
   - password: `password`
6. `php bin/console doctrine:database:create`
7. `php bin/console doctrine:schema:create`
8. go to [https://localhost](https://localhost) to run


## TODO ##
- fixtures to fill DB
- remove requirement for a `data` folder
- fix dev / prod config

Later
- support POST requests
- JWT tokens
- CORS
- authentication, password hash
- forgot password
- 2 factor auth