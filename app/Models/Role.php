<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, HasUuidColumn;

    protected function casts(): array
    {
        return [
            'permissions' => 'array',
        ];
    }
}
