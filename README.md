# Project Name: TapAndGo

This system is about a restourant KIOSK and let the user choose their own orders and pay them in the cashier using a simple code

## Requirement:
* PHP >= 8.2+
* Composer
* Node.Js & NPM

## Installation Setup
Follow these steps to run this project locally

```bash
git clone https://github.com/BrokenClipFan/TapAndGo.git
cd TapAndGo

# Install PHP dependencies:
composer install

# Install JavaScript dependencies:
npm install

# Set up environment configuration:
cp .env.example .env

# Configure Database:
# DB_DATABASE=your_database_name
# DB_USERNAME=root
# DB_PASSWORD=

#Generate Application Key:
php artisan key:generate

# Run Database Migrations:
php artisan migrate

# And finally
php artisan serve