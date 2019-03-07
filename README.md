### About

---------------------

This package built on laravel and vue and contain the following functionalities - 

- Category (with CRUD operation)
- Category TODO Items (with CRUD operation)
- Pagination on frontend-backend side

Steps to configure the package - 

- composer config repositories.local '{"type": "vcs", "url": "https://github.com/mayankkumarji/laravel-vue-todo-list-package"}' --file composer.json

- composer require "Mayank/TodoTask @dev" 

- php artisan vendor:publish --provider="Mayank\TodoTask\TodoTaskServiceProvider" --tag="public"

- php artisan vendor:publish --provider="Mayank\TodoTask\TodoTaskServiceProvider" --tag="views"

- php artisan migrate

- php artisan route:list (optional)

- php artisan serve