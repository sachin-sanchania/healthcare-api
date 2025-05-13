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

## API Documentation [Swagger Implementation]

After successfully running the project, you can check the interactive API documentation in your browser at `/api/documentation`, which will display the Swagger UI with all your annotated API endpoints.

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

## Laravel Healthcare API Dockerized Setup

## 📦 Prerequisites

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- Ensure ports `8080` and `3308` are available on your system.

## 🛠️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/sachin-sanchania/healthcare-api.git
cd healthcare-api
```

### 2. Start Docker Containers

```bash
docker-compose up -d --build
```
This will : 
- Build PHP and Nginx images
- Copy `.env.example` to `.env`
- Generate the Laravel app key
- Run migrations and seeders
- Start all containers

## 🌐 Access the Application

Once all containers are up and running, you can access your Laravel Healthcare API using the following URLs:

- 🔗 **Web App / Laravel Root**: [http://localhost:8080](http://localhost:8080)
- 📘 **API Documentation** (e.g., Swagger or Laravel API Docs): [http://localhost:8080/api/documentation](http://localhost:8080/api/documentation)

---

### 🔎 Quick Verification

1. Open your browser and visit [http://localhost:8080](http://localhost:8080) to check if the Laravel application is running.
2. Visit [http://localhost:8080/api/documentation](http://localhost:8080/api/documentation) to view the API documentation.

If you encounter a **database connection error**, wait a few seconds and refresh the page — MySQL might still be initializing.


## Contributing

Feel free to fork this repository and contribute by submitting a pull request. Bug reports and feature requests are welcome.
