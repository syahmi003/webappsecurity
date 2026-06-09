# Web Application Security Enhancement
### INFO 4345 — Group Project

---

## a. Group Members

|No.| Name                              | Matric No.|
|---|-----------------------------------| ----------|
| 1 | Muhammad Syahmi Firdaus Bin Izham |  2212287  |
| 2 | Muhammad Firdaus Bin Zaini        |  2217753  |
| 3 | Muhammad Rafiqi Bin Mohd Razak    |  2224155  |
| 4 | Muhammad Afiq Bin Abdul Latif     |  2228641  |

---

## b. Title of Web Application

**Hospital Kuala Lumpur — Clinic Management System**

---

## c. Introduction

The Hospital Kuala Lumpur Clinic Management System is an existing web-based application from previous course (Web Application Development INFO 3305) developed using the **Laravel PHP framework**. It was originally built for group project that digitises and streamline the day-to-day operations of a hospital. The system consists of six core modules:

- **Patient Management** — register, update, and search patient records
- **Doctor Management** — manage doctor profiles and schedules
- **Appointment Management** — book and track patient appointments
- **Medical Records** — store diagnoses, treatments, and doctor notes
- **Pharmacy** — manage drug inventory including expiry dates and pricing
- **Billing & Invoices** — create and manage patient invoices and payment status

The application uses a **MySQL** database for data storage, **Blade** templating engine for the front-end views, and **Tailwind CSS / Bootstrap** for styling.

---

## d. Objective of the Enhancements

The objective of this security enhancement project is to identify and fix the security weaknesses present in the original web application. The enhancements aim to protect the system and its users from common web application threats by applying the following security measures:

1. Implement proper **input validation** on both client and server sides across all modules
2. Apply **authentication best practices** including rate limiting, strong password policies, and secure session handling
3. Enforce **authorization** so that all sensitive routes are protected and require an authenticated session
4. Prevent **Cross-Site Scripting (XSS)** and **Cross-Site Request Forgery (CSRF)** attacks
5. Secure **database interactions** to prevent SQL injection and mass assignment vulnerabilities
6. Apply **file and server security** configurations to prevent information leakage

---

## e. Web Application Security Enhancements

---

### i. Input Validation

Input validation ensures that only properly formatted, expected data is accepted by the application. It was applied on both the **client side** (HTML form attributes) and the **server side** (Laravel validation rules) across all modules.

#### Input Elements Validated

The following input elements were validated across all controllers:

| Module          | Fields Validated                                                                                                                  |
|-----------------|-----------------                                                                                                                  |
| Patient         | patient_id, first_name, last_name, email, phone_number, address, gender, date_of_birth                                            |
| Doctor          | doctor_id, doctor_name, department, email_address, schedule, contact_no                                                           |
| Appointment     | appointment_id, patient_id, doctor_id, appointment_date, appointment_time                                                         |
| Medical Record  | record_id, patient_name, diagnosis, treatment, doctor, date_of_record                                                             |
| Drug / Pharmacy | drug_name, manufacture_date, expiry_date, price, quantity                                                                         |
| Invoice         | bill_date, delivery_date, payment_deadline, invoice_id, patient_name, email, subtotal, total_amount, payment_status, items (JSON) |
| Login           | email, password                                                                                                                   |
| Register        | name, email, password, password_confirmation                                                                                      |

#### Client-Side Validation

HTML5 attributes were added to all Blade form inputs to give users immediate feedback before the form reaches the server.

**Example — Login form** (`resources/views/auth/login.blade.php`):
```html
<input
    type="email"
    name="email"
    class="form-control"
    placeholder="Enter email"
    value="{{ old('email') }}"
    required
    maxlength="255"
    autocomplete="email">

<input
    type="password"
    name="password"
    class="form-control"
    placeholder="Password"
    required
    minlength="8">
```

**Example — Register form name field** (`resources/views/auth/register.blade.php`):
```html
<input
    type="text"
    name="name"
    pattern="[A-Za-z\s\-]+"
    title="Name may only contain letters, spaces, and hyphens"
    required
    maxlength="255">
```

#### Server-Side Validation

All `store()` and `update()` methods were updated to use Laravel's `$request->validate()` with strict rules.

**Before — PatientController `update()` had no validation at all:**
```php
// BEFORE (Original)
public function update(Request $request, $id)
{
    $patient = Patient::findOrFail($id);
    $patient->update($request->all()); // No validation applied
}
```

**After — Full validation with proper rules:**
```php
// AFTER (Enhanced)
public function update(Request $request, $id)
{
    $request->validate([
        'first_name'    => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
        'last_name'     => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
        'email'         => 'required|email|max:255|unique:patients,email,' . $id,
        'phone_number'  => 'required|string|max:15|regex:/^[0-9\+\-\s]+$/',
        'address'       => 'required|string|max:500',
        'gender'        => 'required|in:Male,Female',
        'date_of_birth' => 'required|date|before:today',
    ]);

    $patient = Patient::findOrFail($id);
    $patient->update($request->only([
        'first_name', 'last_name', 'email',
        'phone_number', 'address', 'gender', 'date_of_birth',
    ]));
}
```

**Before — InvoiceController `store()` had zero validation:**
```php
// BEFORE (Original)
public function store(Request $request)
{
    $invoice = Invoice::create([
        'bill_date'    => $request->bill_date,   // Raw, unvalidated input
        'email'        => $request->email,
        'total_amount' => $request->total_amount,
        // ...
    ]);
}
```

**After — Complete validation including the JSON items array:**
```php
// AFTER (Enhanced)
$request->validate([
    'bill_date'      => 'required|date',
    'delivery_date'  => 'required|date|after_or_equal:bill_date',
    'invoice_id'     => 'required|string|max:50|unique:invoices,invoice_id',
    'email'          => 'required|email|max:255',
    'total_amount'   => 'required|numeric|min:0',
    'payment_status' => 'required|in:Paid,Unpaid,Pending',
    'items'          => 'required|json',
]);

// Each decoded JSON item is also individually validated
$items = json_decode($request->items, true);
foreach ($items as $item) {
    $itemValidator = validator($item, [
        'description'  => 'required|string|max:255',
        'quantity'     => 'required|integer|min:1',
        'price'        => 'required|numeric|min:0',
        'final_amount' => 'required|numeric|min:0',
    ]);
    if ($itemValidator->fails()) { continue; }
    InvoiceItem::create([...]);
}
```

#### Validation Techniques Used

| Technique | Rule Example | Purpose |
|-----------|-------------|---------|
| Type enforcement | `integer`, `numeric`, `date`, `email` | Ensures correct data type |
| Length limits | `max:255`, `min:8` | Prevents overflow attacks |
| Whitelist values | `in:Male,Female` | Only accepts known values |
| Regex pattern | `regex:/^[\pL\s\-]+$/u` | Allows only letters/spaces/hyphens |
| Relational date | `after:manufacture_date`, `before:today` | Logical date checking |
| Uniqueness | `unique:patients,email` | Prevents duplicate records |
| JSON integrity | `json` rule + per-item validator | Validates structured input |

---

### ii. Authentication

Authentication verifies the identity of users before allowing access to the system, thus several best practices were implemented to harden the authentication process.

#### Methods Implemented

**1. Rate Limiting — Brute Force Protection**

The original application had no rate limiting, meaning an attacker could attempt unlimited password guesses. The enhanced version limits login attempts to **5 per minute** per email and IP address combination.

**Before:** No rate limiting existed — unlimited login attempts were allowed.

**After** (`app/Http/Controllers/Auth/LoginController.php`):
```php
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

$throttleKey = Str::lower($request->email) . '|' . $request->ip();

if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
    $seconds = RateLimiter::availableIn($throttleKey);
    throw ValidationException::withMessages([
        'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
    ]);
}

// Increment counter on failure, clear on success
RateLimiter::hit($throttleKey);   // failed attempt
RateLimiter::clear($throttleKey); // successful login
```

**2. Strong Password Policy**

The original registration only required a minimum of 8 characters. The enhanced version enforces a stronger policy.

**Before:**
```php
'password' => 'required|string|min:8|confirmed'
```

**After** (`app/Http/Controllers/Auth/RegisterController.php`):
```php
use Illuminate\Validation\Rules\Password;

'password' => [
    'required',
    'confirmed',
    Password::min(8)
        ->mixedCase()    // Must contain uppercase AND lowercase letters
        ->numbers()      // Must contain at least one number
        ->symbols()      // Must contain at least one symbol (e.g. @, !, #)
        ->uncompromised(), // Rejects passwords found in known data breaches
],
```

**3. Session Fixation Prevention**

After a successful login, the session ID is regenerated to prevent session fixation attacks where an attacker pre-sets a session ID.

```php
// After successful login
$request->session()->regenerate();
```

**4. Secure Logout**

The original `LoginController` was missing the `logout()` method entirely. The enhanced version properly destroys the session and regenerates the CSRF token on logout.

**Before:** The `logout()` method did not exist in `LoginController`.

**After:**
```php
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();       // Destroy all session data
    $request->session()->regenerateToken();  // Issue new CSRF token
    return redirect()->route('login');
}
```

**5. Password Hashing**

All passwords are stored using `Hash::make()` which applies bcrypt hashing. Passwords are never stored as plain text.

```php
'password' => Hash::make($request->password),
```

The `.env` file is configured with `BCRYPT_ROUNDS=12` for a strong hashing cost factor.

**6. Generic Error Messages**

To prevent attackers from knowing whether an email exists in the system, a single generic error message is returned for any failed login attempt.

```php
return back()->withErrors([
    'email' => 'These credentials do not match our records.',
])->onlyInput('email');
```

---

### iii. Authorization

Authorization controls what authenticated users are allowed to access. This was the most critical vulnerability found in the original application.

#### The Problem

In the original `routes/web.php`, **only the `/home` route was protected** by the `auth` middleware. Every other route — including patient records, doctor data, billing, medical records, and pharmacy — was publicly accessible **without logging in**.

**Before** (`routes/web.php`):
```php
// Only this one route required login
Route::middleware('auth')->get('/home', function () {
    return view('home');
})->name('home');

// All of these were accessible without any login
Route::get('/billing-list', [InvoiceController::class, 'index']);
Route::get('/doctor', [DoctorController::class, 'index']);
Route::get('/patients', [PatientController::class, 'index']);
Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy']);
// ... and all other routes
```

This meant anyone could visit `http://yourdomain.com/patients` or `http://yourdomain.com/billing-list` directly in their browser without ever logging in.

#### The Fix

All sensitive routes were wrapped inside a single `Route::middleware(['auth'])->group()` block. Laravel automatically redirects any unauthenticated request to the login page.

**After** (`routes/web.php`):
```php
Route::middleware(['auth'])->group(function () {

    Route::get('/home', fn() => view('home'))->name('home');

    // Billing — now requires login
    Route::get('/billing-list',     [InvoiceController::class, 'index'])->name('billing-list');
    Route::get('/create-invoice',   [InvoiceController::class, 'create'])->name('create-invoice');
    Route::post('/invoices',        [InvoiceController::class, 'store'])->name('invoices.store');
    Route::delete('/invoice/{id}',  [InvoiceController::class, 'destroy'])->name('invoice.destroy');

    // Doctors — now requires login
    Route::get('/doctor',           [DoctorController::class, 'index'])->name('doctor');
    Route::get('/add-doctor',       [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/add-doctor',      [DoctorController::class, 'store'])->name('doctor.store');

    // Patients, Pharmacy, Medical Records, Appointments...
    // All routes are now inside this protected group
});
```

Any attempt to access a protected page while not logged in will automatically redirect the user to `/login`.

---

### iv. XSS and CSRF Prevention

#### CSRF Prevention

Cross-Site Request Forgery (CSRF) is an attack where a malicious website tricks a logged-in user's browser into making an unwanted request to the application.

Laravel includes built-in CSRF protection via the `VerifyCsrfToken` middleware. Every POST, PUT, and DELETE form must include the `@csrf` Blade directive, which generates a hidden token field that Laravel validates on every form submission.

**Critical Fix — The login button was broken:**

The original login form used an `<a>` tag as the submit button, which means it **never actually submitted the form** — it just redirected directly to the home page, completely bypassing authentication.

**Before:**
```html
<form action="{{ route('login') }}" method="POST">
    @csrf
    <!-- fields -->
    <a href="{{ route('home') }}" class="btn btn-primary">Login</a>  {{-- Never submitted the form! --}}
</form>
```

**After:**
```html
<form action="{{ route('login') }}" method="POST">
    @csrf  {{-- CSRF token included in every form --}}
    <!-- fields -->
    <button type="submit" class="btn btn-primary">Login</button>  {{-- Proper submit button --}}
</form>
```

#### XSS Prevention

Cross-Site Scripting (XSS) is an attack where malicious scripts are injected into web pages viewed by other users.

**1. Blade Auto-Escaping**

Laravel's Blade templating engine automatically HTML-encodes all output rendered using `{{ }}` syntax. This means any user input containing HTML or JavaScript is converted to safe text before being displayed.

```blade
{{-- Safe — HTML-encoded automatically, cannot inject scripts --}}
{{ $patient->patient_name }}

{{-- Example: if patient_name = "<script>alert('hack')</script>"  --}}
{{-- Blade renders it as: &lt;script&gt;alert('hack')&lt;/script&gt;  --}}
{{-- It displays as text, not executable code --}}
```

All views in the enhanced application use `{{ }}` syntax exclusively. The unsafe `{!! !!}` (unescaped output) syntax is never used.

**2. Security Headers Middleware**

A new middleware was created at `app/Http/Middleware/SecurityHeadersMiddleware.php` that adds protective HTTP headers to every response.

```php
// Content-Security-Policy — restricts which scripts and resources can load
$response->headers->set(
    'Content-Security-Policy',
    "default-src 'self'; " .
    "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; " .
    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
    "object-src 'none'; " .
    "form-action 'self';"
);

// Prevents clickjacking — blocks the page from being embedded in iframes
$response->headers->set('X-Frame-Options', 'DENY');

// Prevents MIME-type sniffing attacks
$response->headers->set('X-Content-Type-Options', 'nosniff');

// Controls referrer information sent to external websites
$response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

// Disables browser features not needed by the application
$response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
```

This middleware is registered globally in `bootstrap/app.php` so it applies to every single response:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        SecurityHeadersMiddleware::class,
    ]);
})
```

---

### v. Database Security Principles

#### SQL Injection Prevention

SQL injection is an attack where malicious SQL code is inserted into an input field to manipulate the database query.

**Laravel Eloquent ORM — Parameterized Queries**

The application uses Laravel's Eloquent ORM for all database operations. Eloquent automatically uses **PDO prepared statements** and **parameterized queries**, which means user input is always treated as data, never as SQL code.

```php
// This Eloquent call:
Patient::where('email', $request->email)->first();

// Is equivalent to this safe parameterized SQL:
// SELECT * FROM patients WHERE email = ? LIMIT 1
// The ? is bound safely — even if email = "' OR '1'='1", it won't affect the query
```

User input is never directly concatenated into SQL strings anywhere in the application.

#### Mass Assignment Protection

Mass assignment is a vulnerability where an attacker submits extra hidden fields in a form to overwrite fields they shouldn't be able to change (e.g. submitting `is_admin=1`).

**Before — using `$request->all()` passes every submitted field directly to the model:**
```php
// BEFORE (Original) — vulnerable to mass assignment
Patient::create($request->all());
```

**After — using `$request->only()` whitelists exactly which fields are accepted:**
```php
// AFTER (Enhanced) — only these specific fields are accepted
Patient::create($request->only([
    'patient_id', 'first_name', 'last_name',
    'email', 'phone_number', 'address', 'gender', 'date_of_birth',
]));
```

**Laravel Model `$fillable` — Second Layer of Protection**

All models define a `$fillable` array. Laravel's Eloquent will refuse to assign any field not listed here, even if it is submitted in the request.

```php
// app/Models/Patient.php
class Patient extends Model
{
    protected $fillable = [
        'patient_id', 'first_name', 'last_name',
        'date_of_birth', 'gender', 'phone_number', 'email', 'address',
    ];
}
```

#### Validating JSON Input Before Database Insert

In `InvoiceController`, the original code decoded a JSON string from user input and inserted it directly into the database without any validation. The enhanced version validates every field of every item before inserting.

```php
$items = json_decode($request->items, true);

foreach ($items as $item) {
    // Validate each item individually before inserting
    $itemValidator = validator($item, [
        'description'  => 'required|string|max:255',
        'quantity'     => 'required|integer|min:1',
        'price'        => 'required|numeric|min:0',
        'final_amount' => 'required|numeric|min:0',
    ]);

    if ($itemValidator->fails()) {
        continue; // Skip invalid items instead of inserting bad data
    }

    InvoiceItem::create([
        'invoice_id'   => $invoice->id,
        'description'  => $item['description'],
        'quantity'     => $item['quantity'],
        'price'        => $item['price'],
        'final_amount' => $item['final_amount'],
    ]);
}
```

---

### vi. File Security Principles

#### 1. Protecting the `.env` File

The `.env` file contains sensitive credentials including the database username, password, and application secret key. It is listed in `.gitignore` so it is **never committed to GitHub**.

```
# .gitignore
.env
.env.backup
.env.production
```

For production deployment, `APP_DEBUG` must be set to `false` to prevent detailed error messages from exposing file paths, database credentials, or application logic to users.

```
# .env — production settings
APP_DEBUG=false
APP_ENV=production
```

With `APP_DEBUG=true` (as in the original), any error in the application displays a full stack trace including server paths and configuration details — a major information leak.

#### 2. Laravel's Secure Directory Structure

Laravel's architecture provides built-in file security. The web server's document root points **only** to the `/public` folder. All application code sits outside the web root and is completely inaccessible via HTTP.

```
Project-Web-App-main/
├── app/              ← NOT accessible via browser
├── routes/           ← NOT accessible via browser
├── database/         ← NOT accessible via browser
├── .env              ← NOT accessible via browser
└── public/           ← ONLY this folder is the web root
    └── index.php     ← Single entry point for all requests
```

This means even if someone guesses the URL `http://yourdomain.com/.env`, the server returns a 404 — the file simply cannot be reached through the browser.

#### 3. File and Folder Permissions

Correct file permissions ensure that only the necessary directories are writable by the web server. Everything else should be read-only.

```bash
# Only these two folders need write permissions (for logs, cache, sessions)
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# All application code should be read-only
chmod -R 755 app/
chmod -R 755 routes/
chmod -R 755 resources/
```

#### 4. Session Security

Sessions are stored in the database with encryption enabled and a timeout of 120 minutes. After this period, the user is automatically logged out.

```
# .env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
```

#### 5. Hiding Server Information

The web server configuration suppresses version and technology information from HTTP response headers, making it harder for attackers to identify the server software and target known vulnerabilities.

```apache
# public/.htaccess (Apache)
Header unset X-Powered-By
ServerTokens Prod
ServerSignature Off
```

---

## f. References

1. Laravel Documentation — Validation: https://laravel.com/docs/11.x/validation
2. Laravel Documentation — Authentication: https://laravel.com/docs/11.x/authentication
3. Laravel Documentation — Authorization & Middleware: https://laravel.com/docs/11.x/authorization
4. Laravel Documentation — CSRF Protection: https://laravel.com/docs/11.x/csrf
5. Laravel Documentation — Hashing: https://laravel.com/docs/11.x/hashing
6. OWASP Top Ten Web Application Security Risks: https://owasp.org/www-project-top-ten/
7. OWASP SQL Injection Prevention Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html
8. OWASP XSS Prevention Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html
9. OWASP CSRF Prevention Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html
10. OWASP Authentication Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html
11. Mozilla MDN — Content Security Policy (CSP): https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
12. Mozilla MDN — X-Frame-Options: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options
