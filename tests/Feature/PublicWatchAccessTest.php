<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Watch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicWatchAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_users_can_access_watch_pages_without_logging_in(): void
    {
        $user = User::factory()->create();

        $watch = Watch::create([
            'user_id' => $user->id,
            'url' => 'https://example.com',
            'css_selector' => '.content',
            'check_frequency_minutes' => 15,
            'last_hash' => null,
            'is_active' => true,
        ]);

        $this->get(route('watches.index'))->assertOk();
        $this->get(route('watches.show', $watch))->assertOk();
    }
}
