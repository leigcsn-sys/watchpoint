namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class PageFetcher
{
    public function fetchCleanText(string $url, ?string $cssSelector = null): string
    {
        $response = Http::timeout(15)->get($url);

        if (!$response->successful()) {
            throw new \RuntimeException("Failed to fetch {$url}: HTTP {$response->status()}");
        }

        $crawler = new Crawler($response->body());

        // Remove noisy tags entirely
        $crawler->filter('script, style, noscript, nav, footer, header')->each(function (Crawler $node) {
            foreach ($node as $n) {
                $n->parentNode->removeChild($n);
            }
        });

        $target = $cssSelector
            ? $crawler->filter($cssSelector)
            : ($crawler->filter('main')->count() ? $crawler->filter('main') : $crawler->filter('body'));

        $text = $target->count() ? $target->text('') : '';

        // Normalize whitespace so formatting-only changes don't trigger false positives
        return trim(preg_replace('/\s+/', ' ', $text));
    }

    public function hash(string $text): string
    {
        return hash('sha256', $text);
    }
}