<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ApiSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'key',
        'value',
        'is_active',
        'description',
        'is_encrypted'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_encrypted' => 'boolean',
    ];

    /**
     * Get the decrypted value of the API key.
     *
     * @return string
     */
    public function getDecryptedValueAttribute()
    {
        if ($this->is_encrypted && $this->value) {
            return Crypt::decryptString($this->value);
        }
        
        return $this->value;
    }

    /**
     * Set the value of the API key, encrypting it if necessary.
     *
     * @param string $value
     * @return void
     */
    public function setValueAttribute($value)
    {
        if ($this->is_encrypted && $value) {
            $this->attributes['value'] = Crypt::encryptString($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }

    /**
     * Scope a query to only include active API settings.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include settings for a specific provider.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    /**
     * Get a specific API setting by provider and key.
     *
     * @param string $provider
     * @param string $key
     * @return mixed
     */
    public static function getSetting($provider, $key)
    {
        $setting = self::where('provider', $provider)
                      ->where('key', $key)
                      ->where('is_active', true)
                      ->first();
        
        if (!$setting) {
            return null;
        }
        
        return $setting->is_encrypted ? $setting->decrypted_value : $setting->value;
    }

    /**
     * Get all settings for a specific provider.
     *
     * @param string $provider
     * @return array
     */
    public static function getAllSettings($provider)
    {
        $settings = self::where('provider', $provider)
                        ->where('is_active', true)
                        ->get();
        
        $result = [];
        
        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->is_encrypted ? $setting->decrypted_value : $setting->value;
        }
        
        return $result;
    }
}
