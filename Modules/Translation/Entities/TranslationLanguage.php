<?php

namespace Modules\Translation\Entities;

use Illuminate\Database\Eloquent\Model;

class TranslationLanguage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang_name',
        'slug',
        'is_default',
    ];

    /**
     * Scope a query to get default language.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDefaultLanguage($query)
    {
        return $query->where('is_default', 1);
    }
}
