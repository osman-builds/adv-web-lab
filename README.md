# Student Portal - Advanced Web Application

A comprehensive web application and RESTful API backend for managing academic records, student enrollments, course catalogs, lecturers, and academic departments.

---

## Overview

This project serves as a student portal system providing both interactive web views and a versioned RESTful JSON API. Built with PHP 8.3 and Laravel 13, it adheres to modern web standards, API resource transformations, robust input validation, and automated testing.

### Key Capabilities

* **Course Management & RESTful API**: Versioned endpoints (`/api/v1/courses`) with pagination, custom JSON shaping via `CourseResource`, and full CRUD operations.
* **Search & Filtering**: Search courses by code or title (`?search=`), and filter by minimum credit hours (`?min_credits=`).
* **Aggregate Statistics**: Dedicated statistics endpoint (`/api/v1/courses-stats`) reporting total courses, total credit hours, and average credit hours.
* **Academic Relations**: Relational data structures linking Students, Courses, Lecturers, Departments, and Enrolments with pivot metadata (grades, enrollment timestamps).
* **API Authentication**: Laravel Sanctum token-based authentication via `/api/v1/login`.
* **Postman Integration**: Bundled Postman v2.1 collection and environment under `postman/` for endpoint testing and lab verification.

---

## API Endpoints Reference

All API requests must include the header:
```http
Accept: application/json
```

| Method | Endpoint | Description | Status Code |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/courses` | List courses (paginated, 5 per page) | `200 OK` |
| `GET` | `/api/v1/courses?search={term}` | Search courses by code or title | `200 OK` |
| `GET` | `/api/v1/courses?min_credits={n}` | Filter courses with at least `n` credit hours | `200 OK` |
| `GET` | `/api/v1/courses/{id}` | Retrieve details of a specific course | `200 OK` / `404 Not Found` |
| `POST` | `/api/v1/courses` | Create a new course | `201 Created` / `422 Unprocessable` |
| `PATCH` / `PUT` | `/api/v1/courses/{id}` | Update course attributes | `200 OK` / `422 Unprocessable` |
| `DELETE` | `/api/v1/courses/{id}` | Remove a course | `204 No Content` |
| `GET` | `/api/v1/courses-stats` | Summary statistics (`total_courses`, `average_credit_hours`, etc.) | `200 OK` |
| `POST` | `/api/v1/login` | Authenticate user and receive Sanctum API token | `200 OK` / `422 Unprocessable` |

---

## Database Architecture & Models

* **`Student`**: Student demographic details and course enrolments.
* **`Course`**: Course code (unique), name, credit hours, and assigned lecturer.
* **`Lecturer`**: Faculty details and teaching assignments.
* **`Department`**: Academic departments managing courses and faculty.
* **`User`**: System authentication with API token management (`HasApiTokens`).
* **`Enrolment`**: Many-to-many relationship connecting students and courses with grades and timestamps.

---

## Getting Started

### Prerequisites

* PHP >= 8.3
* Composer
* MySQL or SQLite

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/osman-builds/adv-web-lab.git
   cd adv-web-lab
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run database migrations and seed sample data:**
   ```bash
   php artisan migrate --seed
   ```

5. **Start the local server:**
   ```bash
   php artisan serve
   ```
   The application will be accessible at `http://127.0.0.1:8000`.

---

## Testing

Run the automated test suite using PHPUnit / Artisan:

```bash
php artisan test
```

To run API-specific tests:
```bash
php artisan test --filter=CourseApiTest
```

---

## Postman Integration

Ready-to-use Postman assets are located in the `postman/` directory:

* `postman/Student_Portal_Course_API.postman_collection.json`
* `postman/Student_Portal_Local.postman_environment.json`
* `postman/README.md` (Step-by-step import and screenshot guide)
