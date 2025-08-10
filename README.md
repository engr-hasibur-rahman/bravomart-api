### Installation

Rename file "docker-compose-example.yml" to "docker-compose.yml"

Run docker in your local machine

Run below command in project directory [this command for one time run]

```
bash install.sh
```

Your laravel project runed on docker

Run below command for docker stop/down 

```
vendor/bin/sail down 
```
Or
```
sail down
```

Then everytime you need to run only below command

```
sail up
```

"Ctrl" + "c" for sail stop/down

Connect database to local from docker if need. credentials are in .env file


### Available command
This command freshed migration and seed data seed file and .sql file (follow the instruction)

```
sail artisan biva:install

or 

php artisan biva:install
```



// permission doc

/**
 * *****************************************
 * step-1 
 * bind route "getPermissionMiddleware" method with a any name
 * step- 2
 * Assign permission in "config/middleware.php"
 * step- 3
 * Create permission in "app/Enums/PermissionKey.php"
 * step- 4
 * seed this permission module wise in "database/seeders/PermissionSeeder.php"
 * *****************************************
 */