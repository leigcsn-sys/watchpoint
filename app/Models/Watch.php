<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
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
