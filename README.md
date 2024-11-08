To run an existing Laravel project in your local environment, follow these steps:

Step 1: Install Prerequisites

Ensure you have the following installed on your system:

PHP (8.1 or higher)
Composer (PHP dependency manager)
MySQL (or SQLite) for the database
Node.js for frontend dependencies

Step 2: Clone the Project
git clone <repository_url>
cd <project_folder>

Step 3: Install PHP Dependencies
composer install

Step 4: Set Up Environment Configuration

Update the .env file with your local setup. Set the API_DEV value to point to your JSON server (http://localhost:3000/):
API_DEV=http://localhost:3000/

Step 5: Generate the Application Key
php artisan key:generate

FINAL STEP
php artisan serve
