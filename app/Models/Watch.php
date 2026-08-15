<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'url', 'css_selector', 'check_frequency_minutes', 'last_hash', 'last_error', 'is_active', 'last_checked_at'])]
class Watch extends Model
{
    use HasFactory, HasUlids;

    protected function casts(): array
    {
        return [
            'last_checked_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function snapshots() {
        return $this->hasMany(Snapshot::class);
    }

    public function changeLogs() {
        return $this->hasMany(ChangeLog::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}