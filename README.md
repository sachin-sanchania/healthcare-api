# Healthcare API

A Laravel 12 RESTful API that handles appointment cancellations using clean architecture principles. This project demonstrates best practices including the Service Pattern, policy-based authorization, and implicit route model binding.

## Features

- ✅ Laravel 12 with modern PHP support
- 🧠 Clean service-oriented architecture
- 🔐 Policy-based authorization for secure access
- 🔁 Implicit route model binding
- 📦 RESTful API conventions

## Prerequisites

- PHP >= 8.1
- Composer
- MySQL or compatible database

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/sachin-sanchania/healthcare-api.git
cd healthcare-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment File

```bash
cp .env.example .env
```

After copying the `.env` file, open it in a text editor and **update your MySQL database configuration**:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations and seeders

```bash
php artisan migrate --seed
```

### 6. Serve the Application

```bash
php artisan serve
```

The application will be available at:  
`http://localhost:8000`

## Login Credentials for Generating Login Token

You can use the following credentials to log in and generate tokens for the seeded user:

- **Email**: `johndoe@example.com`
- **Password**: `12345678`

## API Endpoints

> Sample endpoints may include:

| Method | Endpoint              | Description                                  |
|--------|-----------------------|----------------------------------------------|
| POST   | /api/login            | Login with email and password                |
| GET    | /api/professionals    | Get all healthcare professionals             |
| POST   | /api/appointment/book | Book an appointment to selected professional |

> **Note:** Actual endpoints depend on your route setup. Please refer to `routes/api.php`.

## Project Structure

- `app/Services/` – Core business logic
- `app/Policies/` – Authorization logic
- `app/Providers/` – Custom Service Providers. For eg. Exception Handler
- `routes/api.php` – API route definitions
- `app/Http/Requests/` – Request validation
- `app/Http/Controllers/` – HTTP layer controllers

## Contributing

Feel free to fork this repository and contribute by submitting a pull request. Bug reports and feature requests are welcome.
