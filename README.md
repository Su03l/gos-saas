# Governance SaaS — Enterprise Board Portal

## Introduction
A high-security, B2B Multi-Tenant SaaS platform designed for Board Management. This application automates governance workflows, including meeting scheduling, AI-powered minutes generation, legally binding electronic voting, and a secure Virtual Data Room (VDR).

## Tech Stack
- **Backend:** Laravel 13, PHP 8.5 (Strictly Typed)
- **Database:** Isolated SQLite database per tenant for maximum data residency compliance.
- **Frontend:** Laravel Blade, Tailwind CSS, Alpine.js (Livewire-free for performance).
- **Real-time:** Laravel Reverb / Echo for live voting updates.
- **AI:** Integrated with Gemini/OpenAI for automated summarization.

## Multi-Tenant Architecture
This project uses a **Database-per-Tenant** strategy using SQLite:
1. Every tenant has a unique `.sqlite` file in `database/tenants/`.
2. The `TenantIsolationMiddleware` detects the tenant via the current hostname/domain.
3. It dynamically switches the `database.connections.sqlite.database` configuration at runtime.
4. Developers **must** ensure all models use the default `sqlite` connection to remain scoped.

## Getting Started
1. **Clone & Install:**
   ```bash
   git clone https://github.com/Su03l/gos-saas.git
   composer install
   npm install && npm run build
   ```
2. **Environment:**
   Copy `.env.example` to `.env` and configure your central database.
3. **Database Setup:**
   ```bash
   php artisan migrate --seed # Central DB
   php artisan app:create-tenant "Company Name" "comp-a.test" # Create first tenant
   ```
4. **Queue Worker:**
   ```bash
   php artisan queue:work
   ```

## Testing & Quality
- **Pest PHP:** Run `php artisan test` for feature and architecture tests.
- **PHPStan:** Level 9 analysis is enforced. Run `vendor/bin/phpstan analyze`.
- **Pint:** Style consistency is enforced via `vendor/bin/pint`.

## Security Features
- IP Allowlisting per Tenant.
- Forced 2FA for Board Members.
- Cryptographically hashed voting receipts.
- SOC2 compliant PII masking in logs.
- Strict CSP and Security Headers.

---
*Built with privacy and security by design for the modern enterprise.*
