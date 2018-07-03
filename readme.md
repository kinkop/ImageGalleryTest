## Installation

##Map hosts

127.0.0.1   image-gallery.test

##Docker (If want to run with docker)
1. go to "docker" folder
2. docker-compose up -d nginx mariadb


#Installing PHP (With docker)
1. go to "docker" folder
2. docker-compose exec workspace bash
3. composer install
4. php artisan passport:install
5. php artisan migrate
6. php db:seed
7. php artisan storage:link

#Installing Asset
1. npm install
2. npm run watch | npm run hot

#Running
http://image-gallery.test:8080