# Backend Developer Challenge - RestAPI Lavavel 11

This project is a RestAPI built with Laravel 11, which allows managing companies and, 
in turn, the registered agents who can work for those companies, 
incorporates the use of tokens to manage only companies belonging to the user

# Prerequisites

- Docker Desktop
- Git
- PHP 8.2+

# Installation

Clone the repository

```bash
git clone https://github.com/OswaCano/bizeeChallenge.git
cd bizeeChallenge
```

Copy environment variables
```bash
cp .env.example .env
```

Build and lift the containers
```bash
docker compose up -d --build
```

Enter the app container
```bash
docker compose exec app bash
```

Install PHP dependencies
```bash
composer install
```

Generate project key
```bash
php artisan key:generate
```

Execute migrations and seeders
```bash
php artisan migrate --seed
```

## Run the project

The project is visible in
```bash
http://localhost:8000
```

- Auth (obtain token)

Route: POST /api/login

```json
{
    "email": "email@example.com",
    "password": "password"
}
```

Response:
```json
{
    "token": "xxxxxxxxxx"
}
```
Then put the token on the header:
```
Authorization: Bearer {token}
```

## Project Structure
```plaintext
app/
 ├─ Models/
 ├─ Http/
 │   ├─ Controllers/
 │   ├─ Requests/
 ├─ Events/
 ├─ Listeners/
database/
 ├─ migrations/
 ├─ seeders/
routes/
 ├─ api.php
```

## Step by Step

1. Create a company

POST /api/companies

```json
{
    "name": "mega company",
    "state": "TX",
    "use_service": true
}
```
(use_service when is true we're going to use a registered agent, 
instead when is false we're going to use the user as own agent)

2. Check capacity of registered agents in a state in concrete 

GET /api/registered-agent-capacity/{state}

Example: localhost:8000/api/registered-agent/NY

Response:
```json
{
    "available": false | true
}
```

3. Assign a registered agent or the own user as the agent of a company

PUT /api/registered-agent/{company_id}

```json
{
    "use_service": true,
    "company_id": 1
}
```

