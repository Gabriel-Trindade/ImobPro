# 🏠 ImobPro — Real Estate ERP

<p align="center">
  <a href="https://imobpro.alwaysdata.net" target="_blank"><b>Live Demo</b></a> ·
  <a href="#-stack">Stack</a> ·
  <a href="#-architecture--patterns">Architecture</a> ·
  <a href="#-run-locally">Run locally</a> ·
  <a href="#-tests">Tests</a> ·
  <a href="#-roadmap">Roadmap</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php" />
  <img src="https://img.shields.io/badge/PostgreSQL-14%2B-4169E1?logo=postgresql" />
  <img src="https://img.shields.io/badge/Status-Work%20in%20Progress-22c55e" />
</p>

---

## 🌟 About

**ImobPro** is a **Real Estate ERP** for companies to manage:

- **Properties** (availability, attributes, documents)
- **Companies/Branches**, **agents/brokers**, and permissions
- **Contracts**, **rent/sales** flows, and **calendar/scheduling**
- Foundation for **reports** and integrations (files, email, etc.)

Current goals: **portfolio-quality code** + **good practices (SOLID)** with clearly separated layers (**Controllers**, **Services**, **Form Requests**, **Policies**) and **tests with Pest**.

🔗 **Live**: https://imobpro.alwaysdata.net

---

## 🧰 Stack

- **Backend**: Laravel 11 (PHP 8.2+), Eloquent ORM, Form Requests, Policies
- **Database**: PostgreSQL 14+ (dev/tests), compatible with MySQL
- **Views**: Blade
- **Testing**: Pest (Feature + Service/Unit)
- **Tooling**: Migrations, Seeders, Storage (ready for CDN/S3), Jobs/Queues (future)

---

## 🏗️ Architecture & Patterns

- **SOLID** as a guide: domain rules live in **Services** (e.g., `CompanyService::create()`), HTTP orchestration in **Controllers**
- **Form Requests** for input validation
- **Policies/Gates** for authorization
- **Migrations** and **Seeders** versioned
- **Pest** for tests (datasets when useful)

Project layout (summary):

```
app/
  Http/
    Controllers/
    Requests/
    Middleware/
  Models/
  Policies/
  Services/
database/
  migrations/
  seeders/
resources/
  views/   # Blade
tests/
  Feature/
  Unit/    # Services/Domain
```

---

## 🚀 Run locally

### 1) Requirements
- PHP 8.2+
- Composer
- PostgreSQL 14+ (or MySQL if you prefer)
- Node 18+ (if you have assets with Vite)

### 2) Clone & install
```bash
git clone <your-repo-url> imobpro && cd imobpro
composer install
cp .env.example .env
php artisan key:generate
```

Set up your `.env` (PostgreSQL example):
```env
APP_NAME=ImobPro
APP_ENV=local
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=imobpro
DB_USERNAME=postgres
DB_PASSWORD=secret
```

### 3) Database & storage
```bash
php artisan migrate --seed
php artisan storage:link
```

### 4) Start the server
```bash
php artisan serve
# http://127.0.0.1:8000
```
*(If you also have a frontend build via Vite: `npm i && npm run dev`.)*

---

## 🧪 Tests

- **Feature**: routes, controllers, responses, validation via Form Requests
- **Unit/Service**: business rules, transactions, relations

Run:
```bash
php artisan test
# or
./vendor/bin/pest
```

Example (Pest) — company creation:
```php
it('creates a company with address and contacts', function () {
    $payload = [
        'name' => 'ACME LLC',
        'document' => '12345678000199',
        'address' => ['city' => 'São Paulo', 'state' => 'SP', 'zip' => '01001-000', 'street' => 'Praça da Sé', 'number' => '100'],
        'contacts' => [
            ['name' => 'Ana', 'email' => 'ana@acme.com'],
            ['name' => 'Bruno', 'email' => 'bruno@acme.com'],
        ],
    ];

    $resp = $this->post(route('companies.store'), $payload);
    $resp->assertRedirect(route('companies.index'));

    $this->assertDatabaseHas('companies', ['name' => 'ACME LLC']);
    $this->assertDatabaseHas('addresses', ['city' => 'São Paulo']);
});
```

---

## 📸 Screenshots (placeholders)

> Add screenshots of your main flows:
- **Dashboard** — overview
- **Properties** — list, filters, create/edit
- **Agents** — teams, permissions
- **Contracts** — creation/signing flow
- **Reports** — KPIs and exports

```
docs/
  screenshots/
    dashboard.png
    properties-list.png
    properties-form.png
```

---

## 🧱 Components / Modules

Below is an **example “Component Highlight”**. Copy this block and reuse it for each new module (Properties, Agents, Contracts, Finance, Inspections, Reports, Calendar, etc.).

### ✨ Component Highlight — Companies (example)
- **Goal**: register and manage companies/branches using the ERP
- **Service layer**: `App\Services\CompanyService`
  - `create(array $data)`: creates company, address and contacts in a transaction
  - `update(Company $company, array $data)`: updates and syncs relations
- **Business rules**:
  - Contacts’ emails must be unique per company
  - Address required with city/state
- **Validation (Form Request)**: `StoreCompanyRequest`, `UpdateCompanyRequest`
- **Authorization (Policies)**: `CompanyPolicy` (`viewAny`, `create`, `update`, `delete`)
- **Routes**:
  ```
  GET  /companies           -> index
  GET  /companies/create    -> create
  POST /companies           -> store
  GET  /companies/{id}/edit -> edit
  PUT  /companies/{id}      -> update
  DELETE /companies/{id}    -> destroy
  ```
- **Database (tables)**: `companies`, `addresses`, `contacts`  
- **Tests (Pest)**:
  - Feature: create/edit, validation, redirects
  - Unit/Service: transaction + `->load(['address','contacts'])`

<!-- #### 🔧 Component Highlight — Template
> Use this as a template for future modules:

```
### ✨ Component Highlight — <ModuleName>

- **Goal**: <what the module solves>
- **Service layer**: App\Services\<ModuleName>Service
  - <method signatures + purpose>
- **Business rules**:
  - <bullets>
- **Validation (Form Request)**: <FormRequests>
- **Authorization (Policies)**: <Policies>
- **Routes**:
  GET  /<module> ...
  POST /<module> ...
- **Database (tables)**: <tables>
- **Tests (Pest)**:
  - Feature: <cases>
  - Unit/Service: <cases>
``` -->

---

## 🗺️ Roadmap

- [ ] **Properties**: full CRUD, tags/amenities, media (S3-ready)
- [ ] **Agents**: roles/permissions (Policies), scheduling
- [ ] **Contracts**: rent/sales flows, steps, documents
- [ ] **Finance (basic)**: invoices/billings, cost centers
- [ ] **Reports**: occupancy, revenue, lead volume
- [ ] **Audit/Logs**: change history
- [ ] **Integrations**: email, webhooks, messaging
- [ ] **CI**: tests + lint (Pint/Larastan) on GitHub Actions

---

## ☁️ Deploy (Alwaysdata — summary)

1. Code lives in `~/ImobPro` and the website **Document Root** points to `ImobPro/public`  
2. With SSH enabled on the server:
   ```bash
   cd ~/ImobPro
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --force
   php artisan storage:link
   ```
3. **Permissions**:
   ```bash
   chmod -R ug+rw storage bootstrap/cache
   ```
4. Configure `.env` variables with your panel credentials (DB host/user/pass/name)

---

## 🔒 Security

- Always configure `APP_KEY`
- `APP_ENV=production` and `APP_DEBUG=false` in production
- Password hashing with Bcrypt/Argon
- Policies/Gates for restricted areas

---

## 🤝 Contributing

PRs and issues are welcome! Suggested guidelines:
- Clear commit messages (`feat:`, `fix:`, `test:`, `docs:`)
- Tests covering main cases
- Keep SOLID (business rules in the service layer)

---

## 📄 License

MIT © ImobPro
