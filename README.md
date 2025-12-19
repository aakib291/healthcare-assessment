# Healthcare Appointment Booking API

A simple, well-tested RESTful API for booking healthcare appointments, built with Laravel and Laravel Sanctum.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Quick Start](#quick-start)
- [Authentication](#authentication)
- [API Endpoints (Examples)](#api-endpoints-examples)
- [Business Rules](#business-rules)
- [Testing](#testing)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)
- [Author](#author)

---

## 🚀 Features

- Token-based authentication (Laravel Sanctum)
- Appointment booking with **double-booking prevention**
- Appointment status workflow: **pending → confirmed → completed → cancelled**
- Cancellation allowed only **24 hours before** appointment time
- Search available doctors by date, filter by specialization, and sort results
- Patient appointment history and resources for consistent API responses
- Validation and clear HTTP status codes
- Database seeders for fast local testing

---

## 🛠 Tech Stack

- PHP 8+ / Laravel
- MySQL (or any supported database)
- Laravel Sanctum for API tokens
- Eloquent ORM

---

## 📦 Quick Start

Requirements: PHP, Composer, MySQL (or preferred DB)

1. Clone repository

```bash
git clone <your-repository-url>
cd healthcare
```

2. Install dependencies

```bash
composer install
```

3. Environment

```bash
cp .env.example .env
php artisan key:generate
# Update .env with DB settings (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
```

4. Migrate and seed

```bash
php artisan migrate --seed
```

5. Start development server

```bash
php artisan serve
# default: http://127.0.0.1:8000
```

---

## 🔐 Authentication

Register a user:

```http
POST /api/register
Content-Type: application/json
{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

Login and receive token:

```http
POST /api/login
Content-Type: application/json
{
  "email": "test@example.com",
  "password": "password"
}

Response:
{
  "message": "Login successful",
  "token": "1|xxxxxxxxxxxx"
}
```

Use the returned token in the `Authorization` header for protected routes:

```
Authorization: Bearer {token}
```

Example curl (login):

```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

---

## 📅 API Endpoints (Examples)

- Book appointment

```http
POST /api/appointments
Headers: Authorization: Bearer {token}
Body (JSON):
{
  "doctor_id": 1,
  "patient_id": 1,
  "appointment_date": "2025-12-25 10:00:00",
  "notes": "General checkup"
}
```

- Get appointment details

```http
GET /api/appointments/{id}
```

- Update appointment status

```http
PUT /api/appointments/{id}
Body: { "status": "confirmed" }
```

- Cancel appointment

```http
DELETE /api/appointments/{id}
# Note: cancellation allowed only if the appointment is at least 24 hours away
```

- Get available doctors

```http
GET /api/doctors/available?date=2025-12-25T10:00:00&specialization=cardiology&sort=name
```

- Get patient appointments

```http
GET /api/patients/{id}/appointments
```

---

## Business Rules

- Prevents double-booking for the same doctor at the same time.
- Appointments can be cancelled only if more than 24 hours remain before the appointment time.
- Appointment lifecycle: pending → confirmed → completed → cancelled

---

## 🧪 Testing

- Seeded data is available via `php artisan db:seed` (run with migrations in Quick Start).
- Run the test suite:

```bash
php artisan test
```

Manual API testing was done using Postman / Thunder Client.

---

## 📂 Project Structure

Key folders:

- `app/Http/Controllers/Api` — API controllers
- `app/Http/Resources` — API resources
- `database/migrations` — DB schema
- `database/seeders` — sample data
- `routes/api.php` — API routes

---

## 📄 License

This project is provided as-is. 
---

## 👤 Author
Aakib Kachchhi — PHP / Laravel Developer

If you'd like changes to the README (more examples, a full OpenAPI spec, or examples for the frontend), tell me what you'd like and I can add them.

