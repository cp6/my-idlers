# My Idlers - Server/VPS Inventory Manager

> Personal fork of cp6/my-idlers

---

## Fork Information

| Property | Value |
|----------|-------|
| **Upstream** | https://github.com/cp6/my-idlers |
| **Fork Purpose** | Track VPS, dedicated servers, and domains inventory |
| **Local Modifications** | None yet - evaluating for personal use |
| **Sync Strategy** | `git fetch upstream && git merge upstream/master` |

---

## Tech Stack

| Component | Technology |
|-----------|------------|
| **Framework** | Laravel 10+ |
| **Database** | MySQL/MariaDB |
| **Frontend** | Blade + Tailwind CSS |
| **Auth** | Laravel Breeze |

---

## Quick Start

```bash
cd C:\GIT\my-idlers

# Install dependencies
composer install
npm install

# Copy environment
cp .env.example .env

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Compile assets
npm run build

# Serve
php artisan serve
```

---

## Key Features

- Track VPS/dedicated server inventory
- Domain management
- Pricing/renewal tracking
- Provider comparison
- Notes and labels

---

*Last updated: 2026-01-01*
