# GiG Media Test Task

Hello, thank you for checking out my test task for GiG Media.

## Technology Stack

This project utilizes the following stack:
- **Laravel 8.83.27**
- **PHP 8.1.29** (Laravel Support Policy [here](https://laravel.com/docs/8.x/releases#support-policy))
- **MySQL 5.7**

## Local Development Setup

To make it easier to set up the project locally, a [`docker-compose.yml`](docker-compose.yml) file has been created.

An `.env` file is also included in the repository.  
**THIS SHOULD NEVER BE DONE IN PRODUCTION**, but it simplifies setting up the test environment.

### Running Docker

To start the Docker containers, run:
```sh
docker compose up --build
```

If you encounter any issues, check if the required ports for the project are free on your machine.  
Feel free to email me at yauhensin@gmail.com if you need assistance.

### Installing Dependencies

To install the necessary dependencies, run:
```sh
docker exec app composer install
```

The project will be accessible at: [http://127.0.0.1:8080/](http://127.0.0.1:8080/).  
The default Laravel welcome page is retained to quickly verify if everything is set up correctly.

### Seeding the Database

To seed the database with test data, run:
```sh
docker exec app php artisan migrate:fresh --seed
```

### PhpMyAdmin

For convenient database management, PhpMyAdmin is included and accessible at: [http://127.0.0.1:8081/](http://127.0.0.1:8081/).  
Credentials [here](.env#L15).

## Automated Testing

Since the authors of the task are in love with automated tests, a set of feature and unit tests are included.  
Additionally, there is the ability to generate a coverage report:
```sh
docker exec app php artisan test --coverage-html coverage-report
```

## API Documentation

API Documentation is available at: [http://127.0.0.1:8080/docs/](http://127.0.0.1:8080/docs/)  
The API call to `api/posts` with the parameter `with=comments` may cause difficulties for the API Documentation. In this case, please use Postman.
