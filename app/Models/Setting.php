<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    use HasTranslations;

    protected $fillable = [
        'group_id',
        'key',
        'label',
        'help_text',
        'type',
        'value',
        'default_value',
        'options',
        'validation_rules',
        'is_translatable',
        'is_encrypted',
        'order',
    ];

    protected $casts = [
        'label' => 'array',
        'help_text' => 'array',
        'value' => 'array',
        'default_value' => 'array',
        'options' => 'array',
        'validation_rules' => 'array',
        'is_translatable' => 'boolean',
        'is_encrypted' => 'boolean',
        'order' => 'integer',
    ];

    protected $translatable = ['label', 'help_text'];

    /**
     * Get the group that owns this setting
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(SettingsGroup::class, 'group_id');
    }

    /**
     * Get the setting value (decrypt if needed)
     */
    public function getValue(?string $locale = null)
    {
        $value = $this->value ?? $this->default_value;

        // Handle translatable values
        if ($this->is_translatable && is_array($value)) {
            $locale = $locale ?? app()->getLocale();
            $value = $value[$locale] ?? $value[config('app.fallback_locale')] ?? null;
        }

        // Decrypt if encrypted
        if ($this->is_encrypted && $value) {
            try {
                $value = Crypt::decryptString($value);
            } catch (\Exception $e) {
                return null;
            }
        }

        // Type casting
        return $this->castValue($value);
    }

    /**
     * Set the setting value (encrypt if needed)
     */
    public function setValue($value): void
    {
        // Encrypt if needed
        if ($this->is_encrypted && $value) {
            $value = Crypt::encryptString($value);
        }

        $this->value = $value;
    }

    /**
     * Cast value based on type
     */
    protected function castValue($value)
    {
        if ($value === null) {
            return null;
        }

        return match($this->type) {
            'boolean' => (bool) $value,
            'number' => is_numeric($value) ? (float) $value : $value,
            'json' => is_string($value) ? json_decode($value, true) : $value,
            'multiselect' => is_string($value) ? json_decode($value, true) : (array) $value,
            default => $value,
        };
    }

    /**
     * Scope to get by group
     */
    public function scopeInGroup($query, string $groupKey)
    {
        return $query->whereHas('group', function ($q) use ($groupKey) {
            $q->where('key', $groupKey);
        });
    }

    /**
     * Scope to order by order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
