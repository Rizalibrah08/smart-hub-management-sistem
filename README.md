# Smart-Hub Management System

> A comprehensive equipment management and borrowing workflow system built with Laravel 13.7. Designed for organizations requiring real-time equipment tracking, borrowing schedules, and digital check-in operations.

## 📋 Table of Contents

- [Overview](#overview)
- [Key Features](#key-features)
- [System Architecture](#system-architecture)
- [Technology Stack](#technology-stack)
- [System Requirements](#system-requirements)
- [Installation & Setup](#installation--setup)
- [Project Structure](#project-structure)
- [Core Workflow](#core-workflow)
- [API Documentation](#api-documentation)
- [Database Schema](#database-schema)
- [Development](#development)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

**Smart-Hub Management System** is a full-stack web application that streamlines equipment management across organizations. It provides:

- **Web Admin Portal** – Complete management interface for equipment, borrowing schedules, and check-in approvals
- **Mobile API** – RESTful endpoints for mobile/tablet check-in operations
- **Real-time Tracking** – Live equipment status, availability, and borrowing history
- **Approval Workflow** – Multi-step authorization for borrowing and check-in operations
- **Comprehensive Reports** – Equipment usage statistics and audit trails

---

## Key Features

### 🔐 Authentication & Authorization
- Session-based login for admin web portal
- Sanctum token-based API authentication for mobile applications
- Role-based access control (Admin vs Member)
- Secure password hashing with bcrypt (12 rounds)
- CSRF protection on web forms

### 📦 Equipment Management
- **CRUD Operations** – Create, read, update, and soft-delete equipment
- **Status Tracking** – Available, In Use, Maintenance, Damaged statuses
- **Inventory Control** – Real-time quantity tracking with available/total counts
- **Categorization** – Equipment grouping by category
- **Location Tracking** – Asset location and storage information
- **Maintenance Logs** – Last maintenance date and historical tracking

### 📅 Borrowing Schedule Management
- **Request Workflow** – Pending → Approved → Returned status pipeline
- **Quantity Control** – Prevent overborrowing with validation
- **Date Tracking** – Borrow and return dates with overdue detection
- **Auto Status Updates** – Equipment status synchronized with borrowing state
- **Admin Approval** – Multi-step approval process for borrowing requests

### 📱 Mobile Check-In System (Tablet/Mobile)
- **Two-Step Check-in** – Separate borrow and return check-in processes
- **Real-time Synchronization** – Instant API-based operations
- **Approval Workflow** – Admin approval required for all check-ins
- **Condition Tracking** – Notes and observations on equipment condition
- **Atomic Operations** – Transactional updates ensure data consistency

### 📊 Reporting & Analytics
- **Equipment Reports** – Total borrowed, on-time/late returns, average duration
- **Dashboard Metrics** – Equipment availability, pending approvals, overdue items
- **Borrowing History** – Complete audit trail per equipment
- **User Activity** – Track member borrowing patterns

### 🔔 Notification System
- **Database Notifications** – Persistent notification storage
- **Status Tracking** – Read/unread and delivery status
- **Event-Based** – Automatic triggers for approvals, rejections, overdue alerts
- **Extensible Design** – Ready for email/SMS integration

---

## System Architecture

```
┌─────────────────────────────────────────┐
│     User Interfaces                     │
├──────────────────┬──────────────────────┤
│  Admin Dashboard │  Mobile/Tablet App   │
│  (Blade + Vite)  │  (REST API Consumer) │
└──────────────────┴──────────────────────┘
         │                    │
         ├── Session Auth     ├── Sanctum Token
         │                    │
┌─────────────────────────────────────────┐
│  Laravel Application Core               │
├─────────────────────────────────────────┤
│  ┌──────────────────────────────────┐   │
│  │  Routes (Web + API)              │   │
│  └──────────────────────────────────┘   │
│           ↓                              │
│  ┌──────────────────────────────────┐   │
│  │  Middleware (Auth + Admin Check) │   │
│  └──────────────────────────────────┘   │
│           ↓                              │
│  ┌──────────────────────────────────┐   │
│  │  Controllers                     │   │
│  └──────────────────────────────────┘   │
│           ↓                              │
│  ┌──────────────────────────────────┐   │
│  │  Eloquent Models & Relationships │   │
│  └──────────────────────────────────┘   │
└─────────────────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────────┐
│  SQLite Database                        │
├─────────────────────────────────────────┤
│  • users                 • check_ins     │
│  • equipments            • notifications│
│  • borrowing_schedules   • equipment... │
└─────────────────────────────────────────┘
```

---

## Technology Stack

### Backend
| Component | Version | Purpose |
|-----------|---------|---------|
| **Laravel Framework** | 13.7 | Web application framework |
| **PHP** | 8.3+ | Server-side language |
| **Laravel Sanctum** | 4.3 | API token authentication |
| **SQLite** | Latest | Database |
| **Eloquent ORM** | Built-in | Database abstraction |

### Frontend
| Component | Version | Purpose |
|-----------|---------|---------|
| **Vite** | 8.0.0 | Build tool & dev server |
| **Tailwind CSS** | 4.0.0 | Utility-first CSS framework |
| **Blade** | Built-in | Template engine |

### Development Tools
| Tool | Version | Purpose |
|------|---------|---------|
| **Composer** | Latest | PHP package manager |
| **npm** | Latest | Frontend package manager |
| **PHPUnit** | 12.5.12 | Testing framework |
| **Laravel Pint** | 1.27 | Code formatter |

---

## System Requirements

- **PHP** ≥ 8.3
- **Composer** ≥ 2.0
- **Node.js** ≥ 18.0
- **npm** ≥ 9.0
- **SQLite3** (included in PHP)
- **2GB+ RAM** (development), **4GB+ RAM** (production)
- **500MB+ Disk Space** for dependencies

---

## Installation & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd smart-hub-management
```

### 2. Install Dependencies
```bash
# PHP dependencies
composer install

# Frontend dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Run migrations (auto-creates SQLite database)
php artisan migrate

# (Optional) Seed demo data
php artisan db:seed
```

### 5. Build Frontend Assets
```bash
# Production build
npm run build

# Development with hot reload
npm run dev
```

### 6. Start Application
```bash
# Option 1: Development server
php artisan serve

# Option 2: Concurrent dev (frontend + backend)
composer run dev
```

**Access the application:**
- Admin Portal: `http://localhost:8000`
- API Base: `http://localhost:8000/api`
- Default Credentials: Create via `php artisan tinker` or register flow

---

## Project Structure

```
smart-hub-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/              # API controllers (mobile/tablet)
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── EquipmentController.php
│   │   │   │   └── CheckInController.php
│   │   │   ├── AuthController.php # Web auth (admin portal)
│   │   │   ├── EquipmentController.php
│   │   │   └── BorrowingScheduleController.php
│   │   ├── Middleware/
│   │   │   └── AdminOnly.php       # Role verification
│   │   └── Traits/
│   │       └── ApiResponse.php     # Standardized JSON responses
│   ├── Models/
│   │   ├── User.php
│   │   ├── Equipment.php
│   │   ├── BorrowingSchedule.php
│   │   ├── CheckIn.php
│   │   ├── EquipmentReport.php
│   │   └── Notification.php
│   └── Providers/
│       └── AppServiceProvider.php
├── routes/
│   ├── api.php                   # REST API routes
│   ├── web.php                   # Admin portal routes
│   └── console.php
├── database/
│   ├── migrations/               # Database schema
│   ├── seeders/                  # Demo data
│   └── factories/                # Model factories
├── resources/
│   ├── views/
│   │   ├── layouts/              # Template layouts
│   │   ├── auth/                 # Login pages
│   │   ├── equipments/           # Equipment management
│   │   └── borrowing-schedules/  # Borrowing management
│   ├── css/                      # Tailwind configuration
│   └── js/
├── config/                       # Application configuration
├── tests/                        # PHPUnit tests
├── storage/                      # Logs, cache, uploads
├── public/                       # Web server document root
├── bootstrap/                    # Framework bootstrap
├── artisan                       # Artisan CLI
├── composer.json                 # PHP dependencies
├── package.json                  # Frontend dependencies
├── vite.config.js                # Vite configuration
├── phpunit.xml                   # Testing configuration
└── .env.example                  # Environment template
```

---

## Core Workflow

### Equipment Borrowing Process

```
1. CREATE BORROWING REQUEST
   └─→ POST /borrowing-schedules
       ├─ Validate equipment availability
       ├─ Create BorrowingSchedule (status: pending)
       └─ Decrement available quantity

2. ADMIN APPROVAL
   └─→ PUT /borrowing-schedules/{id}/approve
       ├─ Update status to approved
       └─ Send notification to member

3. MEMBER CHECK-IN (BORROW)
   └─→ POST /api/check-ins/borrow
       ├─ Validate approved schedule exists
       ├─ Create CheckIn record
       └─ Await admin approval

4. ADMIN APPROVES BORROW
   └─→ PUT /api/check-ins/{id}/approve
       ├─ Update CheckIn status to approved
       ├─ Record approval metadata
       └─ Equipment marked as in-use

5. MEMBER CHECK-IN (RETURN)
   └─→ POST /api/check-ins/return
       ├─ Validate active borrow exists
       ├─ Create return CheckIn
       └─ Await admin approval

6. ADMIN APPROVES RETURN
   └─→ PUT /api/check-ins/{id}/approve
       ├─ Update BorrowingSchedule to returned
       ├─ Increment available quantity
       ├─ Update equipment status if available
       └─ Update usage reports
```

### Status Transitions

**BorrowingSchedule Status:**
```
pending → approved → returned
                   ↘ overdue (auto-detected)
```

**CheckIn Status:**
```
pending_approval → approved
                 ↘ rejected
```

**Equipment Status:**
```
available ↔ in_use ↔ maintenance ↔ damaged
```

---

## API Documentation

### Authentication

#### Login (Get Token)
```http
POST /api/auth/login HTTP/1.1
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}

Response (200):
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": { ... },
    "token": "abc123..."
  }
}
```

**Usage:** Include token in all subsequent API requests:
```http
Authorization: Bearer abc123...
```

### Equipment Endpoints

#### List Equipment
```http
GET /api/equipments?search=projector&status=available&page=1&per_page=15
Authorization: Bearer {token}

Response (200):
{
  "success": true,
  "data": [ {...}, ... ],
  "pagination": {
    "total": 45,
    "per_page": 15,
    "current_page": 1,
    "last_page": 3
  }
}
```

#### Get Equipment Details
```http
GET /api/equipments/{id}
Authorization: Bearer {token}

Response (200):
{
  "success": true,
  "data": {
    "id": 1,
    "code": "PROJ-001",
    "name": "Projector Sony VPL-FHZ75",
    "category": "Audio Visual",
    "status": "available",
    "quantity": 5,
    "available_quantity": 3,
    "borrowing_history": [ {...}, ... ]
  }
}
```

### Check-In Endpoints

#### Submit Borrow Check-In
```http
POST /api/check-ins/borrow HTTP/1.1
Authorization: Bearer {token}
Content-Type: application/json

{
  "borrowing_schedule_id": 12,
  "notes": "Equipment in good condition"
}

Response (201):
{
  "success": true,
  "message": "Check-in submitted successfully",
  "data": { "id": 45, "status": "pending_approval", ... }
}
```

#### Approve Check-In (Admin)
```http
PUT /api/check-ins/{id}/approve HTTP/1.1
Authorization: Bearer {admin-token}
Content-Type: application/json

{
  "approval_notes": "Approved for member usage"
}

Response (200):
{
  "success": true,
  "message": "Check-in approved",
  "data": { ... }
}
```

#### Reject Check-In (Admin)
```http
PUT /api/check-ins/{id}/reject HTTP/1.1
Authorization: Bearer {admin-token}
Content-Type: application/json

{
  "reason": "Equipment condition not acceptable"
}

Response (200):
{
  "success": true,
  "message": "Check-in rejected",
  "data": { ... }
}
```

**Full API documentation available at:** `/docs/api.md` (create separate file)

---

## Database Schema

### Core Tables

#### users
```sql
id | name | email | password | role | created_at | updated_at
```

#### equipments
```sql
id | code | name | category | status | quantity | available_quantity | 
location | purchase_date | purchase_price | last_maintenance_date | 
notes | created_at | updated_at | deleted_at
```

#### borrowing_schedules
```sql
id | equipment_id | member_id | status | quantity_borrowed | 
borrow_date | expected_return_date | actual_return_date | 
created_at | updated_at
```

#### check_ins
```sql
id | borrowing_schedule_id | equipment_id | member_id | approved_by | 
check_in_type | status | notes | approved_at | created_at | updated_at
```

#### equipment_reports
```sql
id | equipment_id | last_borrowed_by | total_borrowed | 
total_returned_on_time | total_returned_late | 
average_borrow_duration_days | created_at | updated_at
```

#### notifications
```sql
id | user_id | type | title | message | related_entity_type | 
related_entity_id | is_sent | sent_at | read_at | created_at
```

---

## Development

### Running the Application

**Development mode with hot-reload:**
```bash
# Terminal 1: Backend
php artisan serve

# Terminal 2: Frontend
npm run dev

# View logs
php artisan pail
```

### Code Standards

This project follows Laravel best practices:
- PSR-12 code style (format with Laravel Pint)
- Model relationships defined clearly
- Controllers focused on HTTP logic
- Business logic in Models/Services
- Comprehensive error handling

**Format code:**
```bash
composer run lint
```

### Database Commands

```bash
# Create database and run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh database (dangerous!)
php artisan migrate:refresh

# Seed demo data
php artisan db:seed

# Interactive database shell
php artisan tinker
```

---

## Testing

### Run Tests
```bash
# Run all tests
composer run test

# Run specific test
php artisan test tests/Feature/AuthTest.php

# Run with coverage
php artisan test --coverage
```

### Test Structure
```
tests/
├── Feature/          # Integration tests
│   ├── AuthTest.php
│   ├── EquipmentTest.php
│   └── CheckInTest.php
└── Unit/             # Unit tests
    ├── Models/
    └── Traits/
```

---

## Security

### Implemented Security Measures

✅ **Authentication & Authorization**
- CSRF token protection on all web forms
- Secure password hashing (bcrypt, 12 rounds)
- Admin-only middleware for protected routes
- Role-based access control

✅ **Data Integrity**
- Database foreign key constraints with cascade delete
- Transaction support for atomic operations
- Input validation on all endpoints
- SQL injection protection (Eloquent ORM)

✅ **API Security**
- Token-based authentication (Sanctum)
- Per-token rate limiting capability
- CORS configuration in place
- Proper HTTP status codes

### Recommendations
- Enable HTTPS in production
- Use environment variables for secrets
- Implement rate limiting middleware
- Regular security audits
- Keep dependencies updated: `composer update`

---

## Contributing

We welcome contributions! To contribute:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/improvement`)
3. Make your changes with clear commit messages
4. Add/update tests as needed
5. Ensure code passes tests: `composer run test`
6. Format code: `composer run lint`
7. Submit pull request with detailed description

---

## License

This project is open-source software licensed under the [MIT license](LICENSE).

---

## Support

For issues, questions, or suggestions:
- Open an issue on GitHub
- Check existing documentation
- Review API reference

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history and updates.

---

**Last Updated:** May 2026  
**Version:** 1.0.0  
**Status:** Active Development
