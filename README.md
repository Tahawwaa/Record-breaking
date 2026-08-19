# 🏋️ Record-breaking

**Record-breaking** is a workout and strength-tracking app built with **Laravel** and **Filament**. Log your sets, watch personal records get flagged automatically, follow your progress on a chart, and plan your training around a library of categorized exercises — in English or Persian (with full RTL support).

## ✨ Features

* 📊 **Dashboard** — total workouts logged, PRs this month, current streak, favorite exercise, and a preview of your workout plans
* ➕ **Quick add** — log a set (exercise, weight, reps, set number, date) without leaving the dashboard
* 🏆 **Automatic PR detection** — a set is flagged "New PR" the first time it beats every earlier attempt at that exercise
* 📈 **Progress charts** — weight and reps over time, per exercise
* 🏋️ **Exercise library** — every account starts with 10 seeded exercises; each one carries a photo and one or more categories (strength, bodyweight, cardio, powerlifting, isolation, and more), filterable and paginated
* 🗓️ **Workout plans** — build a plan around a day of the week and one or more target muscle groups, and attach exercises (with target sets/reps) either while creating it or afterward
* 📅 **Full history** — every set ever logged, most recent first
* ⚙️ **Per-user preferences** — Gregorian or Jalali (Persian) calendar, kilograms or pounds, and a choice of four color themes
* 🔐 **Accounts** — sign up with just a phone number, username, and password; no email required
* 🛡️ **Admin panel** (Filament) — manage user accounts and the shared exercise library from `/admin`, gated by an `is_admin` flag and sharing the site's own login (no separate admin auth)
* 🎨 **Custom error pages** — themed 404/403/419/429/500/503 pages instead of Laravel's defaults, bilingual and aware of whether you're signed in
* 🌗 **Dark theme UI** — custom Tailwind design, no component library
* 🌐 **Bilingual (English / Persian)** — language switcher, RTL layout, translated validation and flash messages

## 🛠️ Tech Stack

* **Backend:** PHP 8.3+, Laravel 13, Eloquent, Blade
* **Admin panel:** Filament 4
* **Frontend:** Blade + Tailwind CSS v4 (via Vite), vanilla JS (no framework) for the dropdown/modal/date-picker widgets
* **Database:** MySQL
* **Calendar:** `morilog/jalali` for Gregorian ⇄ Jalali conversion
* **Localization:** Laravel's built-in translator (`lang/fa.json`, `lang/fa/validation.php`, `lang/fa/pagination.php`)

## 🏗️ How it's put together

```text
User (username, phone, password)
   ├── Exercise (name, categories[], photo)
   │      └── Record (weight, reps, set_number, date)
   └── WorkoutPlan (name, day_of_week, muscle_groups[])
          └── WorkoutPlanExercise (target_sets, target_reps) → Exercise
```

* `DashboardController` — overview stats, quick-add form, progress chart data, plan previews (renders a public landing page instead when signed out)
* `ExerciseController` — exercise library: list with category filter + pagination, and creation (name, categories, photo)
* `RecordController` — full history + set logging
* `WorkoutPlanController` — plan CRUD, plus attaching/detaching exercises with target sets/reps
* `Record::withPersonalRecords()` — walks records oldest→newest per exercise and flags each new max weight as a PR
* `Preferences` support class — centralizes unit conversion (kg ⇄ lb) and date formatting (Gregorian ⇄ Jalali) so records stay stored in kg regardless of display preference
* `SetLocale` middleware — reads the chosen language from the session (or the signed-in user's saved preference) and applies it for the request
* `app/Filament/Resources/{Users,Exercises}` — the admin panel's two resources

## 🚀 Installation

Clone the repository and install dependencies:

```bash
git clone git@github.com:Tahawwaa/Record-breaking.git
cd Record-breaking
composer install
npm install
```

Set up the environment:

```bash
cp .env.example .env
php artisan key:generate
```

Create a MySQL database and point `.env` at it (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), then run migrations:

```bash
php artisan migrate
php artisan storage:link
```

Build the frontend assets:

```bash
npm run build
# or, while developing:
npm run dev
```

Start the server:

```bash
php artisan serve
```

The app will be available at `http://127.0.0.1:8000`. Sign up for an account from there, then promote yourself to admin so you can reach `/admin`:

```bash
php artisan tinker --execute="
\$u = App\Models\User::where('username', 'your-username')->first();
\$u->is_admin = true;
\$u->save();
"
```

### Demo data

`php artisan db:seed` creates a demo account (`test` / `password`) with sample exercises and records — handy for local development, but **don't run it against a production database**: the password is public knowledge.

### Deploying

The app is set up to run behind HTTPS with security headers on by default in production (`APP_ENV=production`), and has two opt-in `.env` flags (`PUBLIC_DISK_DIRECT`, `PUBLIC_HTML_PATH`) for shared hosts where `public/` can't be the literal web root and there's no SSH to symlink or move things — see the comments in `.env.example`.

## 🗺️ Status

* [x] Database schema (users, exercises, records, workout plans)
* [x] Dashboard with live stats, quick add, progress charts, and plan previews
* [x] Automatic personal-record detection
* [x] Exercise library with categories, photos, filtering, and pagination
* [x] Workout plans with multiple exercises and target muscle groups
* [x] Full workout history
* [x] Accounts (username/phone, no email) and per-user preferences
* [x] Admin panel (Filament) for users and the exercise library
* [x] Custom, bilingual error pages
* [x] Dark theme UI with four color themes
* [x] English / Persian localization with RTL support
* [ ] REST API
* [ ] Mobile app

## 📄 License

This project is currently for educational and personal use.
