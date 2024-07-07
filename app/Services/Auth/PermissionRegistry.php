<?php declare(strict_types=1);

namespace App\Services\Auth;

class PermissionRegistry
{
    private array $permissions = [];

    public function add(string $key): void
    {
        $this->permissions[] = $key;
    }

    public function all(): array
    {
        return $this->permissions;
    }
}
