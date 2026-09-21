<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }

        switch ($setting->type) {
            case 'boolean':
                return (bool) $setting->value;
            case 'json':
                return json_decode($setting->value, true);
            default:
                return $setting->value;
        }
    }

    public static function set(string $key, $value, string $type = 'string', string $group = 'general'): self
    {
        $val = is_array($value) || is_object($value) ? json_encode($value) : (string) $value;
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $val, 'type' => $type, 'group' => $group]
        );
    }
}
