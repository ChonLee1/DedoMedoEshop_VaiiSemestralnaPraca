# DedoMedo eShop

E-shop s medom postavený na Laravel 12 s vlastným CSS.

## Spustenie

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

php artisan serve
npm run dev
```

## Prihlasovacie údaje

| Role  | Email             | Heslo    |
|-------|-------------------|----------|
| Admin | admin@demo.test   | 1234     |
| User  | test@example.com  | password |

## Štruktúra projektu

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── CategoryController.php
│   │   ├── ContactController.php
│   │   ├── HomeController.php
│   │   ├── OrderController.php
│   │   ├── ProductController.php
│   │   └── Api/ProductController.php
│   ├── Middleware/
│   │   └── AdminMiddleware.php
│   └── Requests/
│       ├── StoreCategoryRequest.php
│       ├── StoreProductRequest.php
│       ├── UpdateCategoryRequest.php
│       └── UpdateProductRequest.php
├── Models/
│   ├── Category.php
│   ├── HarvestBatch.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Product.php
│   └── User.php

resources/
├── views/
│   ├── layouts/app.blade.php
│   ├── partials/nav.blade.php, footer.blade.php
│   ├── home.blade.php
│   ├── products/index.blade.php
│   ├── product-detail.blade.php
│   ├── cart.blade.php
│   ├── checkout.blade.php
│   ├── contact/index.blade.php
│   ├── admin-dashboard.blade.php
│   ├── admin-products.blade.php
│   ├── admin-categories.blade.php
│   └── admin-login.blade.php
├── css/
│   ├── app.css
│   ├── base.css
│   ├── nav.css
│   ├── layout.css
│   ├── forms.css
│   ├── buttons.css
│   ├── utils.css
│   └── admin.css
└── js/
    ├── app.js
    ├── api.js
    ├── cart.js
    └── nav.js

routes/
├── web.php
└── api.php
```

## Databázová schéma

```
users
categories ──── products ──── order_items
                    │              │
harvest_batches ────┘              │
                                   │
orders ────────────────────────────┘
```

## Verejné stránky

- `/` - Domovská stránka
- `/products` - Zoznam produktov
- `/products/{id}` - Detail produktu
- `/contact` - Kontaktný formulár
- `/cart` - Košík
- `/checkout` - Pokladňa

## Admin sekcia

- `/admin/login` - Prihlásenie
- `/admin/dashboard` - Dashboard so štatistikami
- `/admin/products` - Správa produktov
- `/admin/categories` - Správa kategórií

## API endpointy

- `GET /api/products` - Zoznam produktov
- `GET /api/products/filter` - Filtrovanie produktov

## Užitočné príkazy

```bash
php artisan migrate:fresh --seed
php artisan route:list
php artisan tinker
```

---

Semestrálna práca VAII | Laravel 12 | SQLite
