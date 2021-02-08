# Todo List

![CI](https://github.com/lbovolini/todo-api/workflows/CI/badge.svg)

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

##### Executar Testes

- Unit

  ```bash
  docker-compose exec -w /var/www/todo todo_api_php_service vendor/bin/phpunit 
  ```

##### Popular base de dados

```bash
docker-compose exec -w /var/www/todo todo_api_php_service php spark db:seed UserSeeder
```