<?php

declare(strict_types=1);

namespace App\SharedKernel;

trait Mapping
{
    /**
     * @param array<string,mixed|null> $data
     */
    private static function asString(array $data, string $key): string
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return '';
        }

        return (string)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     */
    private static function asStringOrNull(array $data, string $key): ?string
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return null;
        }

        return (string)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     */
    private static function asFloat(array $data, string $key): float
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return 0;
        }

        return (float)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     */
    private static function asFloatOrNull(array $data, string $key): ?float
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return null;
        }

        return (float)$data[$key];
    }
}
