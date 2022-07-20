# template for a new project at FRC

Steps to set up a new project:

 - create a new repo based on this template
 - copy then .env.example file to .env
    - modify the .env file to your preference
 - if using docker compose 
   - make sure you have docker installed [get docker](https://docs.docker.com/get-docker/)
   - make sure you have docker-compose installed (or are using compose v2) [install docker compose](https://docs.docker.com/compose/install/compose-desktop/)
   - copy the docker-compose.override.yml.example file to docker-compose.override.yml
   - modify the override file to your preference
   - run docker-compose up -d
   - visit the page in your browser, based on your override configuration (e.g. http://localhost:8080/ or http://my-website.localhost)
 - if using programs installed on your computer (php, composer, etc) you are all set.
 - run composer install
 - run php artisan key:generate
 - run php artisan migrate
 - run php artisan db:seed
 

# notes

- if you see a 'permission denied error'
  - try running 'sudo chown <your-username> ./ -R'
