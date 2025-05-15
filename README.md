# TestTaskWithRefactor

A simple PHP console application for calculating transaction commissions based on BIN and currency, utilizing external APIs for BIN country lookup and exchange rates. The project is structured with SOLID principles and is fully covered by unit tests.

---

## Tech Stack

- **Language:** PHP 8.2+
- **Testing:** PHPUnit 10
- **Containerization:** Docker, Docker Compose
- **Dependencies:** Composer
- **Architecture:** PSR-4, services, DTOs, interfaces

---

## Getting Started

### 1. Clone the repository

git clone https://github.com/SuuuuperSaimon/TestTaskWithRefactor.git
cd TestTaskWithRefactor

### 2. Build and start Docker containers

docker compose up -d

### 3. Install dependencies

docker compose run --rm app composer install

---

## Running the Application

To process transactions from an input file:

docker compose run --rm app php bin/console.php input.txt

- `input.txt` should contain one transaction per line in JSON format.

**Example input.txt:**

{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}

---

## Running Tests

docker compose run --rm app vendor/bin/phpunit

---

## Notes

- The application relies on public APIs: [binlist.net](https://binlist.net/) and [exchangerate.host](https://exchangerate.host/).
- The free tier of binlist.net allows only 5 requests per hour per IP.

---
