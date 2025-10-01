# Contacts Management System - Backend API



A robust Laravel-based RESTful API for managing contacts and groups. This backend provides comprehensive CRUD operations with proper validation, error handling, and database relationships.

## 🚀 Features

- **RESTful API Design** - Clean, consistent API endpoints
- **Eloquent ORM** - Efficient database operations with relationships
- **Comprehensive Validation** - Server-side validation with custom error messages
- **Database Migrations** - Version-controlled database schema
- **CORS Configuration** - Cross-origin resource sharing for frontend integration
- **Clean Architecture** - MVC pattern with proper separation of concerns
- **Error Handling** - Graceful error responses with proper HTTP status codes

## 📋 Prerequisites

- **PHP** >= 8.1
- **Composer** (PHP dependency manager)
- **MySQL** >= 5.7 or **SQLite** >= 3.8
- **Git**

## 🛠️ Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/AskaRasugu/contact_mgmt_test_backend.git
cd contact_mgmt_test_backend
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration


####MySQL
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contacts_app
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Setup

# Run migrations
php artisan migrate

# Seed database with sample data (optional)
php artisan db:seed
```

### 6. Start Development Server

```bash
php artisan serve
```

The API will be available at: **http://localhost:8000**

## 📊 Database Schema

### Contacts Table
```sql
contacts
├── id (Primary Key, Auto Increment)
├── first_name (Required, String, Max 255)
├── last_name (Required, String, Max 255)
├── email (Required, Unique, Email)
├── phone (Nullable, String, Max 20)
├── address (Nullable, Text)
├── birthday (Nullable, Date)
├── notes (Nullable, Text)
├── created_at (Timestamp)
└── updated_at (Timestamp)
```

### Groups Table
```sql
groups
├── id (Primary Key, Auto Increment)
├── name (Required, Unique, String, Max 255)
├── description (Nullable, Text)
├── color (Default: #3B82F6, String, Max 7)
├── created_at (Timestamp)
└── updated_at (Timestamp)
```

### Contact_Group Pivot Table
```sql
contact_group
├── id (Primary Key, Auto Increment)
├── contact_id (Foreign Key → contacts.id)
├── group_id (Foreign Key → groups.id)
├── created_at (Timestamp)
└── updated_at (Timestamp)
```

## 🔌 API Endpoints

### Base URL
```
http://localhost:8000/api
```

### Contacts API

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| `GET` | `/contacts` | List all contacts | `search`, `group_id`, `page` |
| `POST` | `/contacts` | Create new contact | Contact data (JSON) |
| `GET` | `/contacts/{id}` | Get specific contact | Contact ID |
| `PUT` | `/contacts/{id}` | Update contact | Contact ID, Updated data |
| `DELETE` | `/contacts/{id}` | Delete contact | Contact ID |

### Groups API

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| `GET` | `/groups` | List all groups | None |
| `POST` | `/groups` | Create new group | Group data (JSON) |
| `GET` | `/groups/{id}` | Get specific group | Group ID |
| `PUT` | `/groups/{id}` | Update group | Group ID, Updated data |
| `DELETE` | `/groups/{id}` | Delete group | Group ID |

## 📝 API Documentation


## 🏗️ Project Structure

```
contact_mgmt_test_backend/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           ├── ContactController.php    # Contact CRUD operations
│   │           └── GroupController.php      # Group CRUD operations
│   └── Models/
│       ├── Contact.php                      # Contact model with relationships
│       └── Group.php                        # Group model with relationships
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000000_create_contacts_table.php
│   │   ├── 2024_01_01_000001_create_groups_table.php
│   │   └── 2024_01_01_000002_create_contact_group_table.php
│   └── seeders/
│       └── ContactGroupSeeder.php           # Sample data seeder
├── routes/
│   └── api.php                              # API route definitions
├── config/
│   └── cors.php                             # CORS configuration
├── .env.example                             # Environment variables template
├── composer.json                            # PHP dependencies
└── artisan                                  # Laravel command-line tool
```

## 🧪 Testing

### Run Tests
```bash
php artisan test
```

### Test Coverage
```bash
php artisan test --coverage
```

## 🚀 Deployment

### Production Environment Setup

1. **Server Requirements:**
   - PHP >= 8.1
   - MySQL >= 5.7 or PostgreSQL >= 10
   - Web server (Apache/Nginx)

2. **Deployment Steps:**
   ```bash
   # Clone repository
   git clone https://github.com/AskaRasugu/contact_mgmt_test_backend.git
   cd contact_mgmt_test_backend
   
   # Install dependencies
   composer install --optimize-autoloader --no-dev
   
   # Environment setup
   cp .env.example .env
   # Edit .env with production values
   
   # Generate key
   php artisan key:generate
   
   # Run migrations
   php artisan migrate --force
   
   # Cache configuration
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Web Server Configuration:**
   - Point document root to `public/` directory
   - Configure URL rewriting for Laravel
   - Set up SSL certificate

## 🔒 Security Features

- **Input Validation** - Comprehensive server-side validation
- **SQL Injection Prevention** - Eloquent ORM protection
- **CORS Configuration** - Controlled cross-origin requests
- **Rate Limiting** - API request throttling
- **Error Handling** - Secure error messages

## 📈 Performance Optimizations

- **Eager Loading** - Prevents N+1 query problems
- **Database Indexing** - Optimized query performance
- **Response Caching** - Cached API responses
- **Pagination** - Efficient data loading

