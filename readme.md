Business Information Model Tool
=======
Copyright (c) 2016 Piethein Strengholt, piethein@strengholt-online.nl

ABOUT
------------
This is a demo website with Laravel 5 utilizing a Neo4j graph database with NeoEloquent OGM. It is written in PHP/Laravel + jQuery / HTML / CSS (Bootstrap).

REQUIREMENTS
------------
* PHP >= 5.5.9
* OpenSSL PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* Composer
* Git
* Neo4j database

INITIAL DEPLOYMENT
------------
* install Neo4j. I used a docker container for this: `docker run -d --publish=7474:7474 --publish=7687:7687 --volume=$HOME/neo4j/data:/data neo4j:3.0`
* install composer: `curl -sS https://getcomposer.org/installer | php — –filename=composer`
* ssh to the machine, go the www directory
* clone the repository: `git clone https://github.com/pietheinstrengholt/laravel-neo4j-neoeloquent-demo.git .`
* run `composer install --no-dev --optimize-autoloader` , use your github key when asked.
* copy the `.env.example` to `.env` and configure with the correct database settings. If localhost doesn't work, try 127.0.0.1 instead.
* change the following variables:

```
DB_CONNECTION=neo4j
DB_HOST=127.0.0.1
DB_PORT=7474
DB_USERNAME=neo4j
DB_PASSWORD=neo4j
```

* run `php artisan key:generate` to generate an unique key. Add this key to the .env configuration file
* deploy the database, use the following command: `php artisan neo4j:migrate`
* run `php artisan optimize`
* run `php artisan cache:clear`
* run `mkdir -p bootstrap/cache`
* run `mkdir -p storage/framework/cache`
* run `chmod -R 777 storage/`
* run `composer dump-autoload`
* run `php artisan up`


TODO
------------
* Fix user registration (violation of primary key)
* Extend a little bit more
* Add some nice d3js visualisation
