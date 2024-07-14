<?php

declare(strict_types=1);

namespace App\Services\View;

class SidebarRegistry
{
    private array $mainItems = [];

    private array $profileItems = [];

    public function addMainItem(string $name, string $icon, string $route, ?\Closure $params, ?string $permission = null): void
    {
        $this->mainItems[] = [
            'name' => $name,
            'route' => $route,
            'icon' => $icon,
            'params' => $params,
            'permission' => $permission,
        ];
    }

    public function addProfileItem(string $name, string $route): void
    {
        $this->profileItems[] = [
            'name' => $name,
            'route' => $route,
        ];
    }

    public function getMainItems(): array
    {
        return $this->mainItems;
    }

    public function getProfileItems(): array
    {
        return $this->profileItems;
    }

    public function all(): array
    {
        return [
            'main' => array_map(fn ($item) => [
                'name' => $item['name'],
                'icon' => $item['icon'],
                'route' => $item['route'],
                'params' => is_callable($item['params']) ? $item['params'](request()) : [],
                'permission' => $item['permission'],
            ], $this->mainItems),
            'profile' => $this->profileItems,
        ];
    }
}
