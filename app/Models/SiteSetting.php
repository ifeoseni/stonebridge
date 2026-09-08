<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
        'type',
        'order',
    ];

    /**
     * Helper to get a setting value with fallback
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $setting = static::where('key', $key)->first();
        return $setting ? ($setting->value ?? $default) : $default;
    }

    /**
     * Helper to set or update a setting
     */
    public static function set(string $key, ?string $value, string $group = 'general', string $label = '', string $type = 'text'): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label ?: ucfirst(str_replace('_', ' ', $key)),
                'type' => $type,
            ]
        );
    }
}
