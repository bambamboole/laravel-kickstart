<?php declare(strict_types=1);

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use EagerLoadPivotTrait, HasFactory, HasUuidColumn;

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, relatedPivotKey: 'user_id')
            ->using(ProjectMember::class)
            ->withPivot('role_id')
            ->withTimestamps();
    }
}
