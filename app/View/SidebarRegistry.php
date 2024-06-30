<?php

declare(strict_types=1);

namespace App\View;

class SidebarRegistry
{
    private array $mainItems = [];

    private array $profileItems = [];

    public function addMainItem(string $name, string $route, string $icon): void
    {
        $this->mainItems[] = [
            'name' => $name,
            'route' => $route,
            'icon' => $icon,
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
            'main' => $this->mainItems,
            'profile' => $this->profileItems,
        ];
    }
}
