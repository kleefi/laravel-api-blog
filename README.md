# 📰 Laravel 12 REST API - Article & User Management

A Laravel 12 RESTful API project for handling user registration, login, authentication via **Sanctum**, and CRUD operations for user-created articles (posts). The API returns consistent JSON responses and includes validation and proper error handling.

---

## ✨ Features

-   ✅ Register & Login via API
-   🔐 Token-based authentication using Sanctum
-   🔄 Logout and token revocation
-   👤 Retrieve currently authenticated user
-   📝 Full CRUD for user’s own posts
-   📦 Clean and consistent JSON structure
-   ⚠️ Validation and proper error handling
-   🧪 API testing via Postman / REST Client
-   🔁 Optional API versioning (v1, v2, etc.)

---

## 📂 API Endpoints Overview

### 🔐 Auth (Public Routes)

| Method | Endpoint        | Description              |
| ------ | --------------- | ------------------------ |
| POST   | `/api/register` | Register a new user      |
| POST   | `/api/login`    | Log in and receive token |

### 🔒 Auth (Protected Routes - `auth:sanctum`)

| Method | Endpoint      | Description                      |
| ------ | ------------- | -------------------------------- |
| GET    | `/api/user`   | Get currently authenticated user |
| POST   | `/api/logout` | Logout and revoke token          |

### 📄 Posts (Protected Routes - `auth:sanctum`)

| Method | Endpoint          | Description                   |
| ------ | ----------------- | ----------------------------- |
| GET    | `/api/posts`      | Get all posts by current user |
| POST   | `/api/posts`      | Create a new post             |
| GET    | `/api/posts/{id}` | View a single post by ID      |
| PUT    | `/api/posts/{id}` | Update an existing post       |
| DELETE | `/api/posts/{id}` | Delete a post                 |

---

## ✅ Example JSON Responses

### ✔️ Success

```json
{
    "status": "success",
    "message": "Post created successfully",
    "data": {
        "id": 1,
        "title": "My First Post",
        "body": "This is the post content.",
        "created_at": "2025-07-30T12:00:00Z"
    }
}
```
