# 🍯 DedoMedo eShop

E-shop s medom postavený na **Laravel 12** s vlastným CSS.

## 🚀 Spustenie

```bash
# Inštalácia
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Spustenie
php artisan serve      # Backend (http://localhost:8000)
npm run dev            # Frontend (Vite)
```

## 🔑 Prihlasovacie údaje

| Role  | Email              | Heslo    |
|-------|-------------------|----------|
| Admin | admin@demo.test   | 1234     |
| User  | test@example.com  | password |

## 📁 Štruktúra

```
app/
├── Http/Controllers/    # Controllery (Auth, Product, Category, API)
├── Models/              # Eloquent modely (User, Product, Category, Order, ...)
└── Middleware/          # AdminMiddleware

resources/
├── views/               # Blade šablóny
├── css/                 # Vlastný CSS
└── js/                  # JavaScript (AJAX, navigácia)

database/
├── migrations/          # DB schéma
└── seeders/             # Testovacie dáta

routes/
├── web.php              # Web routes
└── api.php              # API routes
```

## 📊 Databáza

```
users ─────────────────────────────────────
categories ──┬── products ──┬── order_items
             │              │
harvest_batches ────────────┘      │
                                   │
orders ────────────────────────────┘
```

## 🛠️ Užitočné príkazy

```bash
php artisan migrate:fresh --seed   # Reset DB
php artisan route:list             # Zobraz routes
php artisan tinker                 # REPL
```

---

**Semestrálna práca VAII** • Laravel 12 • SQLite • Vlastný CSS
