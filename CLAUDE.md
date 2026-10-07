# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Laravel 13 job board, built as a learning project (`LARAVEL_MASTERY`). It is a near-stock Laravel skeleton — the only domain code so far is the `Job` model, its migration, and its factory. `JobController` is an empty resource stub and is not routed yet; `routes/web.php` still only serves `welcome`.

## Commands

```sh
composer setup                  # install deps, .env, key, migrate, npm build
composer dev                    # php artisan dev — server + vite + queue + logs
composer test                   # config:clear then php artisan test
php artisan test --filter=JobTest        # single test class/method
php artisan test tests/Feature/FooTest.php
./vendor/bin/pint               # format (Laravel preset, no pint.json)
npm run dev / npm run build     # vite alone
php artisan migrate:fresh --seed         # rebuild DB + 100 fake jobs
```

`laravel/pao` is installed: it wraps PHPUnit output in an agent-friendly format, so `php artisan test` output is already condensed.

## Database

- **Local dev runs on MySQL** (`.env` → `laravel13-job-board`), even though `database/database.sqlite` exists and `.env.example` says sqlite. Tests run on in-memory sqlite (see `phpunit.xml`).
- The queue table is renamed to `queue_jobs` via `DB_QUEUE_TABLE` (`0001_01_01_000002_create_jobs_table.php`) because the `Job` model already owns the `jobs` table. `config/queue.php` still defaults to `'jobs'` — if `DB_QUEUE_TABLE` goes missing from `.env`, the queue will silently target the job-board table. Keep it set.

## Job model conventions

`App\Models\Job` holds the enum values as static arrays:

```php
public static array $experience = ['entry', 'intermediate', 'senior'];
public static array $category = ['IT', 'Finance', 'Sales', 'Marketing'];
```

These are the single source of truth — the migration builds its `enum('experience', Job::$experience)` column from them and `JobFactory` picks random values from them. Add a category or level here, not in three places.

`$fillable` is commented out in the model, so mass assignment (`Job::create($request->validated())`) will fail until it is uncommented.

## Frontend

Tailwind v4 (4.3.x) through `@tailwindcss/vite`. There is **no `tailwind.config.js` and no `postcss.config.js`**, and none should be added — v4 does its own prefixing via Lightning CSS, so `postcss`/`autoprefixer` are not dependencies either. Everything lives in `resources/css/app.css`:

- `@import 'tailwindcss'` replaces the v3 `@tailwind base/components/utilities` directives (those no longer exist).
- Theme tokens go in the `@theme { }` block (currently `--font-sans`).
- Content scanning is automatic; `@source` lines only add what Vite cannot see (paginator views, compiled Blade in `storage/framework/views`).

Fonts are self-hosted by the Vite plugin — `bunny('Instrument Sans')` in `vite.config.js`, not a CDN `<link>`. `fontaine` is installed to make the plugin emit metric-override fallbacks (`size-adjust`, `ascent-override`) so text does not shift on font swap; without it the build logs a warning and skips them.

## Laravel Boost

Boost is not installed. If it is later added (`composer require laravel/boost --dev && php artisan boost:install`), it regenerates `AGENTS.md` with version-specific guidelines — re-read that file afterwards.
