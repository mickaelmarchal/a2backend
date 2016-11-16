a2backend
=========

Symfony REST Backend for [a2proto](https://github.com/mickaelmarchal/a2proto) - Angular2 prototype.

1. Install docker and use `docker-compose up -d` to start
2. Make sure you have a folder `../data/a2backend/log`
3. Connect to container with `docker-compose run apache-php bash`
4. `cd a2backend`
5. `composer install` -- use defaults for all parameters, except:
    - jwt_key_pass_phrase: `test`

6. `php bin/console doctrine:database:create`
7. `php bin/console doctrine:schema:create`
8. `php bin/console doctrine:fixtures:load`

9. Generate keys for JWT encoding (in project root folder)
    - `mkdir -p var/jwt`
    - `openssl genrsa -out var/jwt/private.pem -aes256 4096`(use `test` as passphrase)
    - `openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem`

10. Add a entry for domain `a2backend.local` into your `/etc/hosts` file
    - `127.0.0.1       a2backend.local`

11. go to [https://a2backend.local](https://a2backend.local) to run


Using the front-end, you can login using account `test@test.com` / password: `test`


## TODO ##
- securing JWT Allow-Origin with config parameter (localhost:* for dev)
- user roles and ACLs
- handle 403 / 401
- forgot password
- 2 factor auth
- XSRF protection for login and post requests