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

