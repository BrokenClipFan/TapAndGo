# TapAndGo

TapAndGo is a **self-service restaurant kiosk system** that allows customers to browse the menu, customize their orders, and generate an order code for payment at the cashier. The system is designed to streamline the ordering process, reduce waiting time, and improve the overall customer experience.

## Features

* 🍽️ Self-service ordering
* 📋 Interactive digital menu
* 🛒 Order customization
* 🔢 Unique order code generation
* 💳 Cashier-assisted payment
* ⚡ Fast and user-friendly interface

## Requirements

Before running the project, make sure you have the following installed:

* PHP **8.2** or later
* Composer
* Node.js & npm
* MySQL or another supported database

## Installation

Clone the repository:

```bash
git clone https://github.com/BrokenClipFan/TapAndGo.git
cd TapAndGo
```

### 1. Install PHP Dependencies

```bash
composer install
```

### 2. Install JavaScript Dependencies

```bash
npm install
```

### 3. Configure the Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Update your `.env` file with your database credentials:

```env
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Run Database Migrations

```bash
php artisan migrate
```

### 6. Build Frontend Assets

For development:

```bash
npm run dev
```

Or for production:

```bash
npm run build
```

### 7. Start the Development Server

```bash
php artisan serve
```

The application will be available at:

```
http://127.0.0.1:8000
```

## Project Structure

```
TapAndGo/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
└── ...
```

## Tech Stack

* **Backend:** Laravel (PHP 8.2+)
* **Frontend:** Blade, JavaScript
* **Database:** MySQL
* **Package Manager:** Composer & npm

## Contributing

Contributions are welcome. Feel free to fork the repository, create a new branch, and submit a pull request.

## License

This project is intended for educational and academic purposes.
