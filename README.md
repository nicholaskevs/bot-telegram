# bot-telegram

Simple Telegram bot to get message content from database and forward it to telegram channel

## How to use

### Requirement

- Docker
- PHP >=8.2
- MySQL
- For windows, add php folder path to system variables `path`, follow this [guide](https://www.computerhope.com/issues/ch000549.htm)

### How to install

1. Download [master here](https://github.com/nicholaskevs/bot-telegram/archive/refs/heads/master.zip)
2. Extract
3. Change `.env.example` into `.env`
4. Go to `config` folder
5. Change `cons.php-template` into `cons.php`
6. Fill in `cons.php` with your data
7. Go to `docker` folder
8. Run `docker compose up`
9. Run `vendor\longman\telegram-bot\structure.sql`
10. Run all sql files in `schema` folder
11. Give execute permission with `chmod +x telegrambot.php`
12. Run `./telegrambot.php` or open `telegrambot.bat` for windows

### Next.js + Laravel

The Next.js frontend lives in [nextjs/](nextjs/) and is served by nginx on the same origin as Laravel:

- `/` and `/_next/*` → Next.js dev server (`nextjs:3000`)
- `/api/*` and `/sanctum/*` → Laravel (`webapp:9000` via PHP-FPM)
- `/phpmyadmin/*` → phpMyAdmin

The Next.js helper at [nextjs/src/lib/api.ts](nextjs/src/lib/api.ts#L1) picks the right base URL automatically: server components hit `http://nginx/api` over the docker network, the browser hits the relative `/api`.

#### One-time Laravel setup (inside the `webapp` container)

```bash
docker compose -f docker/compose.yml exec webapp composer require laravel/sanctum
docker compose -f docker/compose.yml exec webapp php artisan install:api
docker compose -f docker/compose.yml exec webapp php artisan migrate
```

`install:api` publishes the Sanctum config and migrations. The bootstrap and routes are already wired ([laravel/bootstrap/app.php](laravel/bootstrap/app.php#L1), [laravel/routes/api.php](laravel/routes/api.php#L1)). `SANCTUM_STATEFUL_DOMAINS` and `SESSION_DOMAIN` are pre-set to `localhost`.

#### Running it

```bash
docker compose -f docker/compose.yml up --build
```

Then visit `http://localhost` — the home page server-side fetches `/api/ping` and renders the response.

#### SPA cookie auth flow (when you need it)

1. Browser → `GET /sanctum/csrf-cookie` (sets the `XSRF-TOKEN` cookie)
2. Browser → `POST /api/login` with `X-XSRF-TOKEN` header (echo the cookie value)
3. Subsequent requests with `credentials: 'include'` are authenticated via the session cookie. `Route::middleware('auth:sanctum')` works as expected.
