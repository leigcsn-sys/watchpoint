<div align="center">

# Watchpoint

### Automated webpage change detection and alerting

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![SQLite](https://img.shields.io/badge/SQLite-07405E?style=flat-square&logo=sqlite&logoColor=white)](https://sqlite.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=flat-square&logo=alpine.js&logoColor=black)](https://alpinejs.dev)

</div>

---

## Overview

Watchpoint monitors any public webpage on a user-defined schedule and sends an alert the moment its content changes. Rather than reporting a generic "this page changed," it identifies and reports the specific lines that were added or removed — useful for tracking price changes, job postings, government notices, or any page without an RSS feed.

## How it works

Naive change detection compares raw HTML, which triggers false positives constantly — ad refreshes, timestamps, and tracking scripts all cause the page source to change without any meaningful content actually changing.

Watchpoint avoids this by cleaning the page before comparison:

1. **Fetch** — retrieve the page HTML for a given URL.
2. **Clean** — strip scripts, navigation, headers, and footers, then normalize whitespace, leaving only meaningful content.
3. **Hash** — compute a hash of the cleaned text. If it matches the previous check, nothing happened.
4. **Diff** — if the hash differs, generate a line-level diff between the previous and current content.
5. **Notify** — email the user with a summary of exactly what changed.

This pipeline runs on a schedule per watch, using Laravel's task scheduler and queue system.

## Tech stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP) |
| Database | SQLite |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| HTML parsing | Symfony DomCrawler |
| Diffing | jfcherng/php-diff |
| Background processing | Laravel Queues, Task Scheduler |
| Email | Laravel Mail (Markdown mailables) |

## Architecture

**Data model**

- `watches` — a monitored URL, its check frequency, optional CSS selector scope, and last known hash.
- `snapshots` — the cleaned text content captured at each check.
- `change_logs` — a record of detected changes, linking the old and new snapshots with a diff summary.

**Core services**

- `PageFetcher` — retrieves and cleans page content, and computes its hash.
- `DiffGenerator` — produces a human-readable diff between two snapshots.
- `CheckWatchJob` — orchestrates a single check: fetch, hash, compare, diff, log, and notify.

## Getting started

```bash
git clone https://github.com/YOUR-USERNAME/watchpoint.git
cd watchpoint
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

To process checks, run the scheduler and queue worker alongside the app:

```bash
php artisan schedule:work
php artisan queue:work
```

## Possible improvements at scale

- Replace fixed-interval polling with adaptive check frequency based on how often a given page actually changes.
- Move diff generation onto a dedicated queue worker pool to handle higher watch volume.
- Add per-user rate limits on watch creation to prevent abuse.
- Cache recently fetched pages to avoid redundant fetches when multiple users watch the same URL.

## License

This project is open source and available under the MIT License.