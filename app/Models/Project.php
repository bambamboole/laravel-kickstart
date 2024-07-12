<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory, HasUuidColumn;

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, relatedPivotKey: 'user_id')->withTimestamps();
    }
}
