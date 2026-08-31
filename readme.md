# MagaPOS - Point of Sale

MagaPOS is a point-of-sale application built with **Laravel 12** and **AdminLTE 3** to manage your store: products, categories, clients, providers, sales, purchases, spendings, money box, and user roles.

> Upgraded from Laravel 5.7 to Laravel 12 with PHP 8.4 compatibility.

## Requirements

- PHP 8.4 or higher
- Composer 2.x
- Node.js 20+ and npm
- SQLite (default) or MySQL/PostgreSQL

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/tooinfinity/magapos.git
cd magapos
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JS dependencies and build assets

```bash
npm install --ignore-scripts
npm run build
```

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Create the database and run migrations

For SQLite (default):

```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
```

For MySQL, set the `DB_*` values in `.env`, then:

```bash
php artisan migrate:fresh --seed
```

### 6. Start the dev server

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000`.

**Default credentials:** `admin@magapos.app` / `password`

## Packages used

- [Laratrust](https://github.com/santigarcor/laratrust) — Roles & permissions
- [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) — i18n route prefixes
- [realrashid/sweet-alert](https://github.com/realrashid/sweet-alert) — SweetAlert2 toast notifications
- [Spatie Laravel HTML](https://github.com/spatie/laravel-html) — Form & HTML builder
- [Intervention Image](https://image.intervention.io/) — Image manipulation
- [Milon Barcode](https://github.com/milon/barcode) — Barcode generation
- [Laravel UI](https://github.com/laravel/ui) — Bootstrap auth scaffolding

## NPM packages

- [AdminLTE 3](https://adminlte.io/) — Dashboard template
- [FontAwesome Free](https://fontawesome.com/) — Icons
- [iCheck](https://github.com/fronteed/icheck) — Custom checkboxes
- [JsBarcode](https://github.com/lindell/JsBarcode) — Client-side barcode rendering
- [OnScan.js](https://github.com/axenox/onscan.js) — Hardware barcode scanner
- [Noty](https://github.com/needim/noty) — Notifications

## Todo List featured
  - [ ] create a backup and restore for this application
  - [ ] create printing system for my app
  - [ ] Multipe and Soft Delete for Some featured actions
  - [ ] New Design with dark mode toggle
  - [ ] ............

## To fix errors
   - [x] delete category spending
   - [x] fix layout not fit properly
 
