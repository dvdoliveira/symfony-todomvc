Symfony TodoMVC
===============

This code repository is a simple implementation of [TodoMVC] [4] project using Symfony (PHP Framework).

This document contains information on how to download, install, and start using

1 - What you need to start
=============================

Before you clone this repo, make sure you machine has the following:

- Symfony 2.7.~ [How to install] [1]
- PostgreSQL 9.0.~ [How to install] [2]
- Composer [How to install] [3]

2 - How to install Symfony TodoMVC
====================================

- git clone
- composer install
- set the database authentication parameters on app/config/parameters.yml
- php app/console doctrine:database:create
- php app/console doctrine:schema:create
- chmod -R 777 app/logs app/cache
- php app/console assets:install web --symlink


3 - Usage
=============

Start a webserver for the Symfony backend:

`$ php app/console server:run`

Open the TodoMVC client on your browser:

http://localhost:8000

Enjoy! 

[1]: http://symfony.com/doc/current/book/installation.html
[2]: http://www.postgresql.org/download/
[3]: https://getcomposer.org/download/
[4]: http://todomvc.com/

