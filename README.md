# 🏋️ Record-breaking

**Record-breaking** is a personal workout and strength-tracking app built with **Laravel**. Log your sets, watch it automatically flag your personal records, and see your progress on a chart — in English or Persian (with full RTL support).

## ✨ Features

* 📊 **Dashboard** — total workouts logged, PRs this month, current streak, favorite exercise
* ➕ **Quick add** — log a set (exercise, weight, reps, set number, date) without leaving the dashboard
* 🏆 **Automatic PR detection** — a set is flagged "New PR" the first time it beats every earlier attempt at that exercise
* 📈 **Progress charts** — weight and reps over time, per exercise
* 🏋️ **Exercise library** — add exercises on the fly through a custom modal, autocomplete when logging a set
* 📅 **Full history** — every set ever logged, most recent first
* 🌗 **Dark theme UI** — custom Tailwind design, no component library
* 🌐 **Bilingual (English / Persian)** — language switcher, RTL layout, translated validation and flash messages
* 💾 **SQLite by default** — zero-config local storage, no separate database server needed

Not included (by design, for now): user accounts/login, multi-user support, a public API. It's a single-user, self-hosted tracker.

## 🛠️ Tech Stack

* **Backend:** PHP 8.3+, Laravel 13, Eloquent, Blade
* **Frontend:** Blade + Tailwind CSS v4 (via Vite), vanilla JS (no framework) for the dropdown/modal/date-picker widgets
* **Database:** SQLite (default), works with MySQL/PostgreSQL too since it's plain Eloquent
* **Localization:** Laravel's built-in translator (`lang/fa.json`, `lang/fa/validation.php`)

## 🏗️ How it's put together

```text
Exercise (name)
   └── Record (weight, reps, set_number, date)
```

* `DashboardController` — overview stats, quick-add form, progress chart data
* `ExerciseController` — exercise list + creation (the "Add Exercise" modal)
* `RecordController` — full history + set logging
* `Record::withPersonalRecords()` — walks records oldest→newest per exercise and flags each new max weight as a PR
* `SetLocale` middleware — reads the chosen language from the session and applies it for the request

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
touch database/database.sqlite
```

Run migrations (add `--seed` to load sample exercises/records):

```bash
php artisan migrate --seed
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

The app will be available at `http://127.0.0.1:8000`.

## 🗺️ Status

* [x] Database schema (exercises, records)
* [x] Dashboard with live stats, quick add, and progress charts
* [x] Automatic personal-record detection
* [x] Exercise library with custom add-exercise modal
* [x] Full workout history
* [x] Dark theme UI
* [x] English / Persian localization with RTL support
* [ ] User accounts / authentication
* [ ] REST API
* [ ] Mobile app

## 📄 License

This project is currently for educational and personal use.
