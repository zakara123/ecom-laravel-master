<?php

namespace App\Services;

use App\Models\HeaderMenu;

class CommonService {
    public static function getHeaderMenus()
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$menu) {
            $children = HeaderMenu::where('parent', $menu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$child) {
                $grandChildren = HeaderMenu::where('parent', $child->id)->orderBy('position', 'asc')->get();
                if ($grandChildren->isNotEmpty()) {
                    $child->children = $grandChildren;
                }
            }
            $menu->children = $children;
        }
        return $headerMenus;
    }

    public static function isImage($url)
    {
        $pos = strrpos($url, '.');
        if ($pos === false) {
            return false;
        }
        $ext = strtolower(trim(substr($url, $pos)));
        $imgExts = ['.gif', '.jpg', '.jpeg', '.png', '.tiff', '.tif']; // this is far from complete but that's always going to be the case...
        if (in_array($ext, $imgExts)) {
            return true;
        }
        return false;
    }

    public static function doStringMatch($string1, $string2, $caseSensitive = false)
    {
        if (!empty($string1) && !empty($string2)) {
            if ($caseSensitive) {
                return strcmp($string1, $string2) === 0;
            } else {
                return strcasecmp($string1, $string2) === 0;
            }
        }
        return false; // Ensure it returns false if strings are empty or don't match
    }

    public static function breakLineOnWord($text, $word)
    {
        // Escape the word for use in a regex pattern
        $escapedWord = preg_quote($word, '/');
        // Replace the word with the word followed by a line break tag
        return preg_replace("/\b$escapedWord\b/i", "<br>$0", $text);
    }
}


