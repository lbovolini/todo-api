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

##### Arquivo de configuração de ambiente de desenvolvimento

- Crie um arquivo chamado **.env** na pasta raiz da aplicação com o seguinte conteúdo:

  ```bash
  #--------------------------------------------------------------------
  # ENVIRONMENT
  #--------------------------------------------------------------------
  
  CI_ENVIRONMENT = development
  
  #--------------------------------------------------------------------
  # DATABASE
  #--------------------------------------------------------------------
  
  database.default.hostname = todo_api_mariadb_service
  database.default.database = todo
  database.default.username = dev
  database.default.password = dev
  database.default.port = 3306
  database.default.DBDriver = MySQLi
  ```

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

##### Executar Testes

- Unit

  ```bash
  docker-compose exec -w /var/www/todo todo_api_php_service vendor/bin/phpunit 
  ```

##### Executar migrations

```bash
docker-compose exec -w /var/www/todo todo_api_php_service php spark migrate
```

##### Popular base de dados

```bash
docker-compose exec -w /var/www/todo todo_api_php_service php spark db:seed AllSeeder
```