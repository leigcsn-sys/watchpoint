<?php

namespace App\Services;

use Jfcherng\Diff\Differ;
use Jfcherng\Diff\Renderer\RendererFactory;

class DiffGenerator
{
    public function summarize(string $oldText, string $newText): string
    {
        $differ = new Differ(
            explode("\n", wordwrap($oldText, 80)),
            explode("\n", wordwrap($newText, 80))
        );

        $renderer = RendererFactory::make('Unified');

        return $renderer->render($differ);
    }
}