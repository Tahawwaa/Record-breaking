# 🏋️ Record-breaking

**Record-breaking** is a personal workout and fitness tracking application built with **Laravel**.

The goal of the project is to help users track their workouts, record personal records, monitor their progress, and visualize their performance over time.

> 🚧 This project is currently under development.

## ✨ Features

* 👤 Personal user profiles
* 🏋️ Exercise management
* 📋 Workout tracking
* ⚖️ Weight and repetition tracking
* 🏆 Personal Records (PR)
* 📈 Progress charts
* 📅 Workout history
* 🔐 User authentication
* 💾 Local data storage
* 📱 Planned Android application
* 🔌 REST API for mobile applications

## 🛠️ Tech Stack

### Backend

* PHP
* Laravel
* Laravel Eloquent ORM
* Laravel Blade
* REST API

### Database

* MySQL / SQLite

### Frontend

* Blade
* HTML
* CSS
* JavaScript

### Planned

* Android application
* Mobile API integration

## 🏗️ Project Architecture

The application follows the MVC architecture provided by Laravel:

```text
User
 │
 ├── Workouts
 │    └── Workout Sets
 │
 ├── Personal Records
 │
 └── Progress
```

The planned architecture for the Android application is:

```text
Android App
     │
     ▼
  REST API
     │
     ▼
  Laravel
     │
     ▼
  Database
```

## 📊 Progress Tracking

Record-breaking is designed to track important workout metrics such as:

* Weight
* Repetitions
* Exercise
* Workout date
* Personal records
* Strength progression

Progress can be visualized using charts to make changes in performance easier to understand.

## 🚀 Installation

Clone the repository:

```bash
git clone https://github.com/USERNAME/record-breaking.git
```

Enter the project directory:

```bash
cd record-breaking
```

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database in `.env`.

Run migrations:

```bash
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

## 🗺️ Roadmap

* [x] Initialize Laravel project
* [ ] Database design
* [ ] Authentication
* [ ] User profiles
* [ ] Exercise management
* [ ] Workout tracking
* [ ] Personal Records
* [ ] Progress tracking
* [ ] Charts
* [ ] REST API
* [ ] Android application
* [ ] API integration with Android

## 🎯 Project Goal

The main goal of Record-breaking is to build a practical fitness application while learning and applying real-world backend development concepts with Laravel.

The project will gradually evolve from a simple local Laravel application into a complete system with a REST API and Android client.

## 📄 License

This project is currently for educational and personal use.
