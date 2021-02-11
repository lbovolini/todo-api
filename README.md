# Todo List

![CI](https://github.com/lbovolini/todo-api/workflows/CI/badge.svg) [![Coverage Status](https://coveralls.io/repos/github/lbovolini/todo-api/badge.svg?branch=main)](https://coveralls.io/github/lbovolini/todo-api?branch=main)

Todo list API 

##### Tecnologias

- Docker
- PHP 8
- Apache
- Codeigniter 4
- MySQL
- PHPUnit

##### Requisitos

- Docker instalado

##### Restrições

- Suporta somente requisições e respostas do tipo application/json

##### Iniciando a aplicação

- Build

  ```bash 
  sh build.sh
  ```

- Executar

  ```bash 
  sh run-prod.sh
  ```

- Endereço

  ``` http
  http://localhost:8080
  ```


##### Banco de dados

- Criar

  ```bash
  docker-compose exec todo_api_mariadb_service mysql -udev -pdev  -e "CREATE DATABASE IF NOT EXISTS todo";
  ```

- Tabelas

  ```bash
  docker-compose exec -w /var/www/todo todo_api_php_service php spark migrate
  ```

- Popular

  ```bash
  docker-compose exec -w /var/www/todo todo_api_php_service php spark db:seed AllSeeder
  ```

##### Executar Testes

- Unit

  ```bash
  docker-compose exec -w /var/www/todo todo_api_php_service vendor/bin/phpunit 
  ```