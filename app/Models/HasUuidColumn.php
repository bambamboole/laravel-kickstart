<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

trait HasUuidColumn
{
    use HasUuids;

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
