<?php

namespace App\Models\Concerns;

trait GeneratesSlug
{
    public static function makeSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = \Illuminate\Support\Str::slug($value);
        $base = $slug;
        $i = 1;

        while (static::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }
}
