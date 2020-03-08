## Build for local development
To run locally you will need to have the code locally for debugging purposes. This will be defined by the volumes section in your `docker-compose.yml`.
Install a laravel using the following command in the root of this project

`composer create-project --prefer-dist laravel/laravel=7.0.0 app`

A `.env` is required to be able to connect to db. Make sure you have it locally
Check other instructions to run in Dockerfile for your local machine. Otherwise the volume section of your `docker-compose.yml` will not have all the code in the container 
run `docker-compose up`
The app will be avaiable on port 8090
## Build 

## Api Authentication


## Docker compose
in order to run it locally, we need a `docker-compose.yml` to set some values. Follow example below:

```$xslt
version: '2'
services:
  laravel:
    build:
      context: ./
      dockerfile: Dockerfile
      args:
        - WITH_XDEBUG=true
    restart: always
    networks:
      - laravel
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./app:/app
    environment:
      - PHP_IDE_CONFIG=serverName=laravel.local
      - RAPID_API_KEY={rapid-api-key}
      - 'PHP_EXTENSIONS=bcmath bz2 calendar exif gd gettext intl mysqli pcntl pdo_mysql soap sockets sysvmsg sysvsem sysvshm opcache zip redis xsl xdebug'
    links:
      - mysql
  mysql:
    image: mysql:5.7
    restart: always
    environment:
      MYSQL_DATABASE: 'db'
      # So you don't have to use root, but you can if you like
      MYSQL_USER: 'db_user'
      # You can use whatever password you like
      MYSQL_PASSWORD: 'db pass'
      # Password for root access
      MYSQL_ROOT_PASSWORD: 'root db pass'
    networks:
      - laravel
    ports:
      # <Port exposed> : < MySQL Port running inside container>
      - '3306:3306'
    expose:
      # Opens port 3306 on the container
      - '3306'
    volumes:
      - ./my-db:/var/lib/mysql
networks:
  laravel:
    external: false



``` 