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

![Welcome page](public/images/app-screenshots/screnshot-for-readme-02.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-03.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-04.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-05.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-06.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-07.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-08.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-09.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-10.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-11.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-12.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-13.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-14.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-15.png)
![Welcome page](public/images/app-screenshots/screnshot-for-readme-16.png)




## 📬 Contact Form

The application includes a Livewire-powered contact form on the welcome page.  
Users can send messages directly, and the app will dispatch an email to the configured support address.

### Features
- Livewire 3 component (`ContactForm`) with real-time validation
- Sends email via Laravel Mail system
- Flash message feedback with Alpine.js animations
- Rate limiting to prevent spam submissions

### Configuration

Set up your mail driver in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_user
MAIL_PASSWORD=your_mailtrap_pass
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="YourApp"
```

For local development, you can use:

```MAIL_MAILER=log```
This will log outgoing emails to `storage/logs/laravel.log` instead of sending them.

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
