<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait HasSlug
 * 
 * Menyediakan auto-generation slug yang unique untuk model
 * Menghilangkan duplikasi kode antara Berita dan Pengumuman
 */
trait HasSlug
{
    /**
     * Boot trait untuk register event listeners
     */
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            $model->generateUniqueSlug();
        });

        static::updating(function ($model) {
            $slugField = $model->getSlugSourceField();
            
            if ($model->isDirty($slugField) && !$model->isDirty('slug')) {
                $model->generateUniqueSlug();
            }
        });
    }

    /**
     * Generate unique slug dari source field
     */
    public function generateUniqueSlug(): void
    {
        $slugField = $this->getSlugSourceField();
        $sourceValue = $this->{$slugField};

        if (empty($this->slug) || $this->isDirty($slugField)) {
            $slug = Str::slug($sourceValue);
            $originalSlug = $slug;
            $count = 1;

            // Check untuk uniqueness
            $query = static::where('slug', $slug);
            
            // Exclude current record saat update
            if ($this->exists) {
                $query->where('id', '!=', $this->id);
            }

            while ($query->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
                
                $query = static::where('slug', $slug);
                if ($this->exists) {
                    $query->where('id', '!=', $this->id);
                }
            }

            $this->slug = $slug;
        }
    }

    /**
     * Mendapatkan nama field yang digunakan sebagai source slug
     * Override method ini jika field berbeda dari 'judul'
     * 
     * @return string
     */
    public function getSlugSourceField(): string
    {
        return property_exists($this, 'slugSourceField') 
            ? $this->slugSourceField 
            : 'judul';
    }

    /**
     * Mendapatkan route key name untuk URL
     * 
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
