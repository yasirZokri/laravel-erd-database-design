Laravel ERD Database Design

A Laravel project focused on database design, relationships, CRUD operations, authentication, and custom middleware.

Overview

This project was built to practice designing a structured and scalable database using an Entity Relationship Diagram (ERD) and implementing it in a Laravel application.

The system includes CRUD operations, user authentication, and custom middleware for controlling access to protected areas of the application.

Features

- Database design based on an ERD
- Relational database structure
- CRUD operations
- User registration and login
- Authentication and logout
- Protected routes
- Custom middleware
- Laravel migrations and Eloquent relationships
- Clean and structured backend architecture

Technologies

- PHP
- Laravel
- MySQL
- Blade
- HTML & CSS
- JavaScript
- Bootstrap

Project Structure

The project follows Laravel's standard architecture and makes use of:

- Models & Eloquent ORM
- Controllers
- Migrations
- Middleware
- Routes
- Blade Views
- Database Relationships

Getting Started

1. Clone the repository

git clone https://github.com/yasirZokri/laravel-erd-database-design.git
cd laravel-erd-database-design

2. Install dependencies

composer install
npm install

3. Configure environment

Copy the example environment file:

cp .env.example .env

Generate the application key:

php artisan key:generate

Configure your database settings in ".env".

4. Run migrations

php artisan migrate

5. Start the development server

php artisan serve

For frontend assets:

npm run dev

What I Learned

This project helped me improve my understanding of:

- Designing relational databases
- Creating and managing database relationships
- Building CRUD functionality with Laravel
- Authentication and protected routes
- Creating and using custom middleware
- Structuring Laravel applications
- Developing backend systems with scalability in mind

Author

Yasir Zokri

Freelance Software Developer

GitHub:
https://github.com/yasirZokri
