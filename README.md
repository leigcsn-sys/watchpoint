<div align="center">

# Watchpoint

**A webpage change tracker — get notified with exactly what changed, not just that something did.**

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![SQLite](https://img.shields.io/badge/SQLite-07405E?style=flat-square&logo=sqlite&logoColor=white)](https://sqlite.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

</div>

---

## The problem this solves

Some pages you need to keep an eye on don't notify you when they change — a government notice board, a product page, a job listing, a small business's pricing page. The only option is to manually check back and hope you catch it. Watchpoint does that checking for you, on a schedule, and tells you the specific lines that changed instead of a vague "something's different."

## Why it's interesting (technically)

Most naive "did this page change" tools just compare raw HTML — which breaks constantly, because a page's HTML changes on every load even when nothing meaningful did (ads rotate, timestamps tick, tracking scripts inject noise). Watchpoint strips all of that out first — scripts, navigation, headers, footers — normalizes what's left, and only then compares. When something real changes, it runs an actual text diff and shows the specific added/removed lines, styled like a terminal diff.

Fetch page → strip noise → hash & compare → diff the text → log the change

## How to use it

Create an account to keep your watch list private and available across sessions.

1. Click **Add Watch**
2. Paste a URL you want to monitor
3. (Optional) Add a CSS selector to scope tracking to one part of the page — e.g. `.article-body` — instead of the whole page
4. Set how often it should check
5. Click **Check Now** to run the first check (this becomes the baseline — no diff yet, since there's nothing to compare against)
6. Every check after that compares against the last one, and logs a diff if anything changed

## Tech stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13 (PHP) |
| Database | SQLite |
| Frontend | Blade, Tailwind CSS |
| HTML parsing | Symfony DomCrawler |
| Diffing | jfcherng/php-diff |
| Background jobs | Laravel Jobs / Queue |

## What's actually implemented

- Page fetching with content cleaning (strips scripts/nav/headers before comparing)
- Hash-based change detection to avoid false positives
- Line-level diffing with a styled diff viewer
- Per-watch error tracking (shows why a check failed, instead of failing silently)
- SSRF protection — blocks requests to private/internal IP ranges in production, so the fetcher can't be abused to probe internal infrastructure
- Rate limiting on watch creation and manual checks
- ULID-based identifiers instead of sequential integers (so watch URLs aren't easily guessable/enumerable)

## Running it locally

\`\`\`bash
git clone https://github.com/YOUR-USERNAME/watchpoint.git
cd watchpoint
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
\`\`\`

Open `http://127.0.0.1:8000`, register an account, and then add your first watch.

## What I'd change for production

- Manual checks are queued and show a "checking..." state while the queue worker fetches the page
- Scheduled background checks (via Laravel's scheduler) instead of manual-only checking
- Adaptive check frequency instead of a fixed interval, based on how often a given page actually tends to change

## License

MIT