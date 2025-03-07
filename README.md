This repository contains a Laravel 12 application with a laravel passport authentication and REST apis for CRUD.

## Branches

This repo has the following branches:

- **main**: Contains the base Laravel 12 code.
- **sail-setup**: Derived from `main`, this branch has laravel sail setup.
- **apis**: Derived from `sail-setup`, Contains the code related to the laravel passport and REST apis.

### Branch Hierarchy:
- main -> sail-setup -> apis

## Pull Request
A Pull Request has been created from `apis` to `sail-setup` for easy code review.

[PR]()

## Solution Details

The primary feature of this repository is Laravel REST apis with authentication. Below are the key files:

### Controllers
- `app/Http/Controller/api/AuthController.php`
- `app/Http/Controller/api/ProjectController.php`
- `app/Http/Controller/api/AttributeController.php`
- `app/Http/Controller/api/TimesheetController.php`

### Services
- `app/Services/ProjectFilter.php`
- `app/Services/AttributeFilter.php`
- `app/Services/TimesheetFilter.php`

### Models
- `app/Models/User.php`
- `app/Models/Project.php`
- `app/Models/Timesheet.php`
- `app/Models/Attribute.php`
- `app/Models/AttributeValue.php`

### Migrations
- Database migration files are located in `database/migrations`.

### Schema
Below tables are created:

1. `users` [id, first_name, last_name, email, password]
2. `projects` [id, name, status]
3. `project_user` [id, user_id, project_id]
4. `timehsheet` [id, task_name, hours, date, user_id, project_id]
5. `attribute` [id, name, type]
6. `attribute_value` [id, attribute_id, entity_id, value]


## Setup Guidelines

### Prerequisites

- Docker
- WSL2 (for Windows users)

### Setup Steps

1. **Clone the repository**:
    ```bash
    git clone git@github.com:tayyabhussainit/laravel.git
    cd laravel
    ```

2. **Checkout the `apis` branch**:
    ```bash
    git checkout apis
    ```

3. **Copy the environment file**:
    ```bash
    cp .env.example .env
    ```

4. **Install dependencies**:
    ```bash
    docker run --rm -v $(pwd):/app -w /app laravelsail/php82-composer:latest composer install
    ```

5. **Start the project using WSL (required for setup on windows)**:
    ```bash
    wsl -d ubuntu
    ```

6. **Go to the project directory (inside WSL, required for setup on windows)**.

7. **Start the Docker containers**:
    ```bash
    ./vendor/bin/sail up -d
    ```

8. **Generate the application key**:
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

9. **Run migrations**:
    ```bash
    ./vendor/bin/sail artisan migrate
    ```

## Code Quality: PHP Code Sniffer

To ensure code quality, PHP Code Sniffer was used to check the code for any violations of coding standards.

### Running PHP Code Sniffer

1. **Access the Docker container**:
    ```bash
    ./vendor/bin/sail bash
    ```

2. **Run PHP Code Sniffer on specific files or directories**:

    - To check the `Controllers`:
      ```bash
      ./vendor/bin/phpcs -v app/Http/Controller/api
      ```

    - To check the `Services` directory:
      ```bash
      ./vendor/bin/phpcs -v app/Services/
      ```

    - To check the `Models` directory:
      ```bash
      ./vendor/bin/phpcs -v app/Models/
      ```

## Postman collection
[collection](https://github.com/tayyabhussainit/laravel/blob/apis/Laravel.postman_collection.json)

