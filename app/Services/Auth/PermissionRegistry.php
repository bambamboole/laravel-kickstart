<?php declare(strict_types=1);

namespace App\Services\Auth;

class PermissionRegistry
{
    private array $permissions = [];

    public function add(string $key): void
    {
        match (enum_exists($key)) {
            true => $this->addEnum($key),
            default => $this->permissions[] = $key,
        };
    }

    public function all(): array
    {
        return $this->permissions;
    }

    private function addEnum(string $key): void
    {
        $this->permissions = array_merge(
            $this->permissions,
            array_map(fn (\BackedEnum $permission) => $permission->value, $key::cases()),
        );
    }
}
