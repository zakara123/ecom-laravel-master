<?php

namespace App\Services;
use App\Models\Setting;

class ThemeService {

    /**
     * viewName
     *
     * @param  mixed $type
     * @return string
     */
    public function name(array $views) : string
    {
        try {
        $settings = Setting::where('key', 'store_theme')->value('value');
        $theme = $settings ? $settings : 'default';
        if($theme == 'default') {
            return $views[$theme];
        }
        return 'templates.'.$theme.'.'.$views[$theme];

        } catch (\Exception $e) {
            return $views['default'];
        }
    }

    /**
     * viewName
     *
     * @param  mixed $type
     * @return string
     */
    public static function getTheme() : string
    {
        $settings = Setting::where('key', 'store_theme')->value('value');
        return $settings ?: 'default';
    }
}


