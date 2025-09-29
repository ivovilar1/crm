<?php

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes, Relations\HasMany};

class Customer extends Model
{
    use HasFactory;
    use HasSearch;
    use SoftDeletes;

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
