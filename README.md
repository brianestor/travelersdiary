# Travelers Diary

Safari site for fixed-date departures. A reservation is a request the desk confirms. Nothing is charged online.

The site is the Laravel app in `laravel-app`. MySQL holds the tours, departures, reservations, diary pages, and contact notes.

```bash
cd laravel-app
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

Copy `.env.example` to `.env`, set `DB_DATABASE` to `travelers_diary`, and set `ADMIN_PASSWORD` before using the staff desk at `/admin`. Then run `php artisan key:generate` and `php artisan migrate --seed`.
