<?php

/**
 * Laravel PHPStan Configuration
 * IDE helper for autocomplete and static analysis
 */

namespace PHPSTORM_META;

override(\app(), map([
    'cache' => \Illuminate\Cache\CacheManager::class,
    'config' => \Illuminate\Config\Repository::class,
    'db' => \Illuminate\Database\DatabaseManager::class,
    'auth' => \Illuminate\Auth\AuthManager::class,
    'hash' => \Illuminate\Hashing\HashManager::class,
]));

// Helper for Laravel Facades
expectedArguments(\route(), 0, argumentsSet('routes'));
expectedArguments(\redirect(), 0, argumentsSet('routes'));
expectedArguments(\view(), 0, argumentsSet('views'));
