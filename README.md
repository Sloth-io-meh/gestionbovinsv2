# GestionBovins - Secure Cattle Management System

A modern, secure rebuild of the GestionBovins application in **Laravel 12** with comprehensive security fixes addressing all vulnerabilities from the security audit.

## 📋 Overview

GestionBovins is a farm management system for tracking:
- 🐄 Cattle/Bovine animals (purchase, weight, sale/mortality)
- 🥕 Feed inventory and nutrition tracking
- 💊 Medicines and pharmaceutical inventory
- 🏥 Veterinary visits and health records
- 🚚 Transportation and vehicle management
- 🏠 Multiple farm facilities (étables)
- 👥 User management and role-based access control

## 🔐 Security Improvements

This rebuild addresses **all F-grade vulnerabilities** from the original audit:

### ✅ Security Headers (Phase 2)
- **Strict-Transport-Security (HSTS)** - Force HTTPS
- **Content-Security-Policy (CSP)** - Prevent XSS attacks
- **X-Frame-Options: DENY** - Prevent clickjacking
- **X-Content-Type-Options: nosniff** - Prevent MIME sniffing
- **Referrer-Policy** - Control referrer sharing
- **Permissions-Policy** - Camera, microphone, geolocation disabled
- Removes `X-Powered-By` header (both PHP-native and Laravel layers)
- HttpOnly, Secure, SameSite=Strict cookies

### ✅ Authentication & Data Protection (Phase 3-4)
- **Password hashing** - bcrypt with 12 rounds (no more plain text)
- **SQL Injection prevention** - Eloquent ORM with parameterized queries
- **Input validation & sanitization** - Form Request classes for all entities
- **SanitizeInput middleware** - strip_tags + trim on all incoming data
- **CSRF protection** - Laravel built-in CSRF middleware on all forms
- **Secure sessions** - Database-backed sessions with security flags
- **Rate limiting** - 5 login attempts via LoginRequest + throttle:120,1 on all auth routes

### ✅ Logging & Auditing (Phase 5)
- **Audit trail** - Every CRUD operation logged with user & timestamp (Spatie Activity Log v4)
- **Auth event logging** - Login, logout, failed attempts recorded
- **Security event logging** - Permission denials captured

### ✅ Role-Based Access Control (Phase 6-7)
- `is_admin` boolean on users table with `Gate::define('admin', ...)`
- **Laravel Policies** for all 10+ resources (Bovin, Stock, Meds, Visite, Etable, Vendeur, Veto, Tansporteur, Vehicule, Quarantaine)
- `@can` Blade directives guard all create/edit/delete UI actions
- `authorizeResource()` in every controller constructor

### ✅ Frontend & File Security (Phase 7-8)
- **XSS prevention** - Blade template auto-escaping throughout
- **Nginx hardening** - Deny access to `package.json`, `package-lock.json` via location blocks
- **DoS protection** - `throttle:120,1` middleware on all authenticated routes
- **Bootstrap 5** - Responsive, accessible UI with consistent badge/pagination/breadcrumb components

### ✅ Services Layer (Phase 8)
- `BovinService` - `markSold()`, `markDead()`, `updateWeight()` extracted from controller
- `InventoryService` - `deductStock()`, `deductMeds()` with quantity validation

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+ / MariaDB or SQLite (dev)
- Git

### Local Development Setup

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database and run migrations
php artisan migrate

# Start development server
php artisan serve
```

Visit: http://localhost:8000

### Docker Setup (Recommended for production)

```bash
# Start all services
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# View logs
docker-compose logs -f app
```

Visit: http://localhost:8000

## 📊 Security Audit Improvements

**Original Audit Results: F grade (20/100)**

| Issue | Before | After | Fix |
|-------|--------|-------|-----|
| Missing CSP | ❌ | ✅ | SecurityHeaders middleware |
| Missing HSTS | ❌ | ✅ | Strict-Transport-Security header |
| Missing X-Frame-Options | ❌ | ✅ | X-Frame-Options: DENY |
| Missing X-Content-Type-Options | ❌ | ✅ | nosniff header |
| Missing Referrer-Policy | ❌ | ✅ | strict-origin-when-cross-origin |
| Missing Permissions-Policy | ❌ | ✅ | Camera, mic, geo disabled |
| X-Powered-By header leak | ❌ | ✅ | header_remove() + middleware |
| Plain-text passwords | ❌ | ✅ | bcrypt 12 rounds |
| MySQLi SQL injection risk | ❌ | ✅ | Eloquent ORM |
| No CSRF protection | ❌ | ✅ | Laravel CSRF middleware |
| No logging/traceability | ❌ | ✅ | Spatie Activity Log audit trail |
| XSS vulnerability | ❌ | ✅ | Blade auto-escaping + CSP |
| No access control | ❌ | ✅ | Gates + Policies (RBAC) |
| Insecure cookies | ❌ | ✅ | HttpOnly, Secure, SameSite=Strict |
| No rate limiting | ❌ | ✅ | 5 login attempts + throttle middleware |
| Exposed package files | ❌ | ✅ | Nginx location block deny |

**Expected result: A+ grade (90+/100)**

## 🧪 Test Suite

```bash
php artisan test
```

**36 tests / 81 assertions** — all passing.

Covers: authentication, security headers, CSRF, session security, RBAC policies, activity logging, CRUD operations, rate limiting.

## 📁 Project Structure

```
gestionbovins-secure/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Resource controllers (10+ entities)
│   │   ├── Middleware/
│   │   │   ├── SecurityHeaders.php   # All security response headers
│   │   │   └── SanitizeInput.php     # strip_tags + trim on all input
│   │   └── Requests/             # Form Request validation classes
│   ├── Models/                   # Eloquent models with LogsActivity trait
│   ├── Policies/                 # Laravel authorization policies
│   └── Services/
│       ├── BovinService.php      # Cattle business logic
│       └── InventoryService.php  # Stock/meds deduction with validation
├── config/session.php            # Session security flags
├── docker/nginx.conf             # Hardened Nginx configuration
├── database/migrations/          # Full schema migrations
├── resources/views/              # Blade templates (Bootstrap 5)
│   └── components/               # Reusable: breadcrumbs, status-badge, action-button
├── routes/web.php                # Auth + throttle middleware on all routes
└── tests/                        # Feature & unit tests
```

## 🔧 Environment Variables

```env
# Database
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST:-localhost}
DB_DATABASE=${MYSQLDATABASE:-gestionbovins}
DB_USERNAME=${MYSQLUSER:-root}
DB_PASSWORD=${MYSQLPASSWORD:-}

# Session security
SESSION_COOKIE_SECURE=true
SESSION_COOKIE_HTTP_ONLY=true
SESSION_COOKIE_SAME_SITE=strict

# Production
APP_ENV=production
APP_DEBUG=false
```

## 📈 Implementation Phases

- ✅ **Phase 1**: Project setup & Laravel 12 scaffolding
- ✅ **Phase 2**: Security headers middleware (HSTS, CSP, X-Frame-Options, nosniff, Referrer-Policy, Permissions-Policy)
- ✅ **Phase 3**: Authentication — bcrypt, secure sessions, CSRF
- ✅ **Phase 4**: Core CRUD — Bovins, Stock, Meds, Visites with Eloquent ORM
- ✅ **Phase 5**: Audit logging — Spatie Activity Log + auth event listeners
- ✅ **Phase 6**: Input validation — SanitizeInput middleware + Form Request classes
- ✅ **Phase 7**: RBAC — Gates, Policies, `@can` guards on all UI actions
- ✅ **Phase 8**: Final hardening — Nginx fix, Services layer, rate limiting, UpdateStockRequest

---

**Version**: 1.0.0 | **Status**: Complete | **Tests**: 36 passing (81 assertions)
