<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Get a translation for a specific field
     */
    public function getTranslation(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? App::getLocale();
        
        // Access attributes directly to avoid infinite loop with getAttribute
        if (!array_key_exists($field, $this->attributes)) {
            return null;
        }
        
        $value = $this->attributes[$field];

        // If it's JSON string, decode it
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            }
        }

        if (is_array($value)) {
            return $value[$locale] ?? $value[config('app.fallback_locale')] ?? null;
        }

        return $value;
    }

    /**
     * Set a translation for a specific field
     */
    public function setTranslation(string $field, string $locale, $value): self
    {
        $translations = $this->getTranslations($field);
        
        $translations[$locale] = $value;
        
        // setAttribute override'ı array gelirse parent::setAttribute çağırır, bu da castAttributeAsJson'a gider.
        // Ancak burada direkt attributes'a yazmak yerine setAttribute kullanmak daha güvenli (mutator varsa).
        // Ama setAttribute override'ımız array gelirse parent'a paslıyor.
        
        $this->setAttribute($field, $translations);

        return $this;
    }

    /**
     * Check if field has translation
     */
    public function hasTranslation(string $field, string $locale): bool
    {
        $value = $this->getAttribute($field);
        
        if (is_array($value)) {
            return isset($value[$locale]);
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) && isset($decoded[$locale]);
        }

        return false;
    }

    /**
     * Get all translations for a field
     */
    public function getTranslations(string $field): array
    {
        // Access attributes directly
        if (!array_key_exists($field, $this->attributes)) {
            return [];
        }
        
        $value = $this->attributes[$field];

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }

    /**
     * Magic getter for translatable attributes
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        // Check if this attribute is translatable
        if ($this->isTranslatableAttribute($key) && !is_null($value)) {
            return $this->getTranslation($key);
        }

        return $value;
    }

    /**
     * Magic setter for translatable attributes
     */
    public function setAttribute($key, $value)
    {
        // Check if this attribute is translatable and value is not an array
        if ($this->isTranslatableAttribute($key) && !is_array($value)) {
            return $this->setTranslation($key, App::getLocale(), $value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Check if attribute is translatable
     */
    protected function isTranslatableAttribute(string $key): bool
    {
        return property_exists($this, 'translatable') && in_array($key, $this->translatable);
    }

    /**
     * Cast translatable attributes to array before saving
     */
    protected function castAttributeAsJson($key, $value)
    {
        if ($this->isTranslatableAttribute($key) && is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return parent::castAttributeAsJson($key, $value);
    }
}
