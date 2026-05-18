# 🏢 Governance SaaS — Board & Committee Governance Portal

![Laravel Version](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP Version](https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 📖 Project Overview
Welcome to the **Governance SaaS** repository. This is an Enterprise-level Board & Committee Governance Portal designed for ultimate security, legal compliance, and real-time collaboration. It automates critical workflows such as AI-powered meeting minutes, legally binding electronic voting, and encrypted Virtual Data Room (VDR) storage.

---

## 🏗 Architecture
This application utilizes a strict **Database-per-Tenant** architecture using **SQLite**:
- **Total Isolation:** Every enterprise client (Tenant) gets their own isolated `.sqlite` database file.
- **Tenant Middleware:** The `TenantIsolationMiddleware` automatically intercepts the request domain, identifies the tenant, and dynamically swaps the `database.connections.sqlite.database` at runtime.
- **Data Residency & SOC2:** Ensures that cross-tenant data leaks are mathematically impossible at the database layer.

---

## 💻 Tech Stack
- **Backend Framework:** Laravel 13
- **Language:** PHP 8.5 (Strictly Typed `declare(strict_types=1)`)
- **Database Engine:** Central SQLite (for routing/tenants) & Isolated SQLite (per tenant)
- **Frontend UI:** Laravel Blade, Tailwind CSS v4, Alpine.js (Lightweight & Fast, No Livewire)
- **PDF Generation:** `carlos-meneses/laravel-mpdf` for robust RTL Arabic support & watermarking
- **Real-time Engine:** Laravel Reverb & Echo (WebSockets)
- **AI Integration:** Google Gemini / OpenAI

---

## 🚀 Local Setup

### 1. Prerequisites
Ensure you have the following installed on your machine:
- PHP 8.5+
- Composer
- Node.js & NPM
- Laravel Herd / Valet (Recommended for local routing)

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/Su03l/gos-saas.git
cd gos-saas

# Install PHP dependencies
composer install

# Install NPM dependencies & build assets
npm install && npm run build
```

### 3. Environment Configuration
Copy the environment file and generate the application key:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Initialization
Run the central migrations to build the primary routing database:
```bash
php artisan migrate:fresh
```

### 5. Running the Arabic Demo Seeder
To instantly populate the application with a highly realistic, SOC2 compliant Arabic dataset (including companies, board members, meetings, and legally binding resolutions), run:
```bash
php artisan db:seed --class=RealisticArabicDemoSeeder
```
*This will create active tenants like `ufoq.test` and `tanmiyah.test`.*

---

## ⚙️ Queues & Jobs
Heavy lifting, such as generating watermarked PDFs or sending email notifications, is offloaded to the queue. 

To run the workers locally:
```bash
php artisan queue:work --verbose --tries=3 --timeout=90
```
*In production, this is managed by Laravel Horizon backed by Redis.*

---

## 🧪 Testing & Code Quality
We enforce strict architectural boundaries and maximum code quality.

**Run the Test Suite (Pest PHP):**
Includes strict tenant isolation and architecture tests.
```bash
php artisan test
```

**Run Static Analysis (PHPStan Level 9):**
```bash
vendor/bin/phpstan analyze
```

**Format Code (Laravel Pint):**
```bash
vendor/bin/pint
```

---

## 🚢 Zero-Downtime Deployment
Deployments are handled via **PHP Deployer**. The configuration file `deploy.php` orchestrates a release-based strategy:
1. Clones the latest `main` branch into a new release folder.
2. Runs `composer install` & `npm run build`.
3. Caches routes, views, and configs.
4. Updates the persistent symlinks (`.env`, `storage`).
5. Switches the active `current` symlink to the new release without dropping active HTTP connections.

To deploy manually (if authorized):
```bash
dep deploy production
```

---

*Built with passion, performance, and uncompromising security.* 🔐
