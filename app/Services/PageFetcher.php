<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class PageFetcher
{
    public function fetchCleanText(string $url, ?string $cssSelector = null): string
    {
        $this->assertUrlIsSafe($url);

        $response = Http::timeout(15)
            ->withOptions(['allow_redirects' => ['strict' => true]])
            ->get($url);

        if (!$response->successful()) {
            throw new \RuntimeException("Failed to fetch {$url}: HTTP {$response->status()}");
        }

        $crawler = new Crawler($response->body());

        $crawler->filter('script, style, noscript, nav, footer, header')->each(function (Crawler $node) {
            foreach ($node as $n) {
                $n->parentNode->removeChild($n);
            }
        });

        $target = $cssSelector
            ? $crawler->filter($cssSelector)
            : ($crawler->filter('main')->count() ? $crawler->filter('main') : $crawler->filter('body'));

        $text = $target->count() ? $target->text('') : '';

        return trim(preg_replace('/\s+/', ' ', $text));
    }

    protected function assertUrlIsSafe(string $url): void
    {
        $parsed = parse_url($url);

        if (!in_array($parsed['scheme'] ?? '', ['http', 'https'])) {
            throw new \InvalidArgumentException('Only http and https URLs are allowed.');
        }

        // Allow local/private addresses only in local development, so you can
        // test against your own machine without exposing this in production.
        if (app()->environment('local')) {
            return;
        }

        $host = $parsed['host'] ?? '';
        $ip = filter_var($host, FILTER_VALIDATE_IP) ? $host : gethostbyname($host);

        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            throw new \InvalidArgumentException('This URL points to a private or reserved network and cannot be watched.');
        }
    }

    public function hash(string $text): string
    {
        return hash('sha256', $text);
    }
}