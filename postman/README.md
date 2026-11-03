# Postman Integration - Student Portal Course API

This directory contains the ready-to-import Postman Collection and Environment for testing the RESTful Course API developed for **Week 9: Building a RESTful API**.

## Files Included

1. **`Student_Portal_Course_API.postman_collection.json`**
   - Contains all lab requests pre-configured with headers (`Accept: application/json`, `Content-Type: application/json`) and validation tests.
   - Grouped into:
     - **Part B – Read Endpoints** (R1, R2, R3)
     - **Part C – Write Endpoints** (R4, R5, R6, R7, R8, R9)
     - **Part D – Independent Exercise** (Step 10.1 Search, Step 10.2 Filter, Step 10.3 Stats, Step 10.4 Auth Login)
2. **`Student_Portal_Local.postman_environment.json`**
   - Configures variables:
     - `base_url`: `http://127.0.0.1:8000`
     - `student_id_last4`: Last 4 digits of your Student ID (default `4321`)
     - `student_name`: Your Name
     - `created_course_id`: Set dynamically by request R4 for chaining to R7, R8, and R9.
     - `auth_token`: Token saved upon login for Part D.

---

## How to Import into Postman

1. Open **Postman**.
2. Click **Import** (top left).
3. Select and import both files:
   - `postman/Student_Portal_Course_API.postman_collection.json`
   - `postman/Student_Portal_Local.postman_environment.json`
4. In the top-right environment selector in Postman, choose **Student Portal Local Environment**.
5. Edit the environment variables `student_id_last4` and `student_name` with your actual Student ID and Name.

---

## Running the Laravel Server

Make sure your local server is running:

```bash
php artisan serve
```

---

## Lab Screenshot Mapping Guide

Use these requests to capture required screenshots **S1 – S14**:

| Request | Endpoint | Expected Status | Purpose |
| :--- | :--- | :--- | :--- |
| **R1** | `GET /api/v1/courses` | `200 OK` | Paginated courses list (`data`, `links`, `meta`) |
| **R2** | `GET /api/v1/courses/1` | `200 OK` | Single course wrapped in `data` |
| **R3** | `GET /api/v1/courses/99999` | `404 Not Found` | Route model binding 404 response |
| **R4** | `POST /api/v1/courses` | `201 Created` | Create new course with your student ID & name |
| **R5** | `POST /api/v1/courses` | `422 Unprocessable` | Validation error (empty code & credit_hours: 9) |
| **R6** | `POST /api/v1/courses` | `422 Unprocessable` | Duplicate code validation error |
| **R7** | `PATCH /api/v1/courses/{id}` | `200 OK` | Update credit_hours to 4 |
| **R8** | `DELETE /api/v1/courses/{id}` | `204 No Content` | Delete the created course |
| **R9** | `GET /api/v1/courses/{id}` | `404 Not Found` | Verify deletion of course |
| **Part D1** | `GET /api/v1/courses?search=web` | `200 OK` | Search courses matching query |
| **Part D2** | `GET /api/v1/courses?min_credits=3` | `200 OK` | Filter courses by minimum credits |
| **Part D3** | `GET /api/v1/courses-stats` | `200 OK` | Aggregate statistics (count, sum, avg) |
| **Part D4** | `POST /api/v1/login` | `200 OK` | Sanctum API token generation |
