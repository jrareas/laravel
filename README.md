## Build for local development
To run locally you will need to have the code locally for debugging purposes. This will be defined by the volumes section in your `docker-compose.yml`.
Install a laravel using the following command in the root of this project

`composer create-project --prefer-dist laravel/laravel=7.0.0 app`

A `.env` is required to be able to connect to db. Make sure you have it locally
Check other instructions to run in Dockerfile for your local machine. Otherwise the volume section of your `docker-compose.yml` will not have all the code in the container 
run `docker-compose up`
The app will be avaiable on port 8090
## Build 