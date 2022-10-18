<?php

use Modules\Translation\Entities\TranslationLanguage;

if (!function_exists('default_language')) {
    /**
     * Get the default language slug.
     *
     * @param bool $obj
     * @return string|TranslationLanguage
     */
    function default_language($obj = false)
    {
        $def_lang = TranslationLanguage::defaultLanguage()->first();

        return $obj ? $def_lang : $def_lang->slug;
    }
}
