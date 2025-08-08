# 🎬 CineMemo

**CineMemo** is a personal media tracker built with Laravel. It helps users keep notes about what they’ve watched — whether it's a movie, series, anime, or any other media type. Organize your thoughts, track your progress, and never forget what you’ve seen.

---

## 🚀 Features

- ✍️ Add notes about any content you watch
- 🎞️ Categorize content by type (Movie, Serial, Anime, etc.)
- 🏷️ Add genres, statuses (e.g., Watching, Watched), and tags
- 📁 Upload related images or posters
- 📊 Filter and search through your library
- 🌗 Light & dark mode ready (optional)
- 🔐 User authentication and personal data separation

---

## 📦 Tech Stack

- Laravel 12
- Livewire 3 (for reactive components)
- Tailwind CSS
- Alpine.js (optional)
- MySQL / SQLite

---

## ⚙️ Installation

### Prerequisites

* PHP >= 8.2
* Composer
* Laravel
* Node.js & npm

### Steps

1. Clone the repository

```git clone https://github.com/Volodymyr0587/laravel-cinememo```

```cd laravel-cinememo```

2. Install dependencies

```composer install```

```npm install```

```npm run dev```

3. Set up the environment

```cp .env.example .env```

```php artisan key:generate```

4. Database setup

Using SQLite for simplicity. Update your .env file accordingly:

```DB_CONNECTION=sqlite```

5. Run migrations

```php artisan migrate:fresh```

6. [OPTIONAL] Run migrations with seeder

```php artisan migrate:fresh --seed```

This will create user (email: volodymyr@gmail.com, password: password123) and some data to explore

7. Create a symbolic link for storage

```php artisan storage:link```

8. Serve the application

    ```php artisan serve```

## Usage

Register a new user and start managing your favorite content.
