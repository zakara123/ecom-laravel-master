<?php

namespace App\Observers;

use App\Models\HeaderMenu;

class HeaderMenuObserver
{
    /**
     * Handle the HeaderMenu "created" event.
     *
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return void
     */
    public function created(HeaderMenu $headerMenu)
    {
        if (is_null($headerMenu->position)) {
            $headerMenu->position = HeaderMenu::where('parent', $headerMenu->parent)->max('position') + 1;
            return;
        }

        $lowerPriorityHeaderMenus = HeaderMenu::where('parent', $headerMenu->parent)
            ->where('position', '>=', $headerMenu->position)
            ->get();

        foreach ($lowerPriorityHeaderMenus as $lowerPriorityHeaderMenu) {
            $lowerPriorityHeaderMenu->position++;
            $lowerPriorityHeaderMenu->saveQuietly();
        }
    }

    /**
     * Handle the HeaderMenu "updated" event.
     *
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return void
     */
    public function updated(HeaderMenu $headerMenu)
    {
        if ($headerMenu->isClean('position')) {
            return;
        }

        if (is_null($headerMenu->position)) {
            $headerMenu->position = HeaderMenu::where('parent', $headerMenu->parent)->max('position');
        }

        if ($headerMenu->getOriginal('position') > $headerMenu->position) {
            $positionRange = [
                $headerMenu->position, $headerMenu->getOriginal('position')
            ];
        } else {
            $positionRange = [
                $headerMenu->getOriginal('position'), $headerMenu->position
            ];
        }

        $lowerPriorityHeaderMenus = HeaderMenu::where('parent', $headerMenu->parent)
            ->whereBetween('position', $positionRange)
            ->where('id', '!=', $headerMenu->id)
            ->get();

        foreach ($lowerPriorityHeaderMenus as $lowerPriorityHeaderMenu) {
            if ($headerMenu->getOriginal('position') < $headerMenu->position) {
                $lowerPriorityHeaderMenu->position--;
            } else {
                $lowerPriorityHeaderMenu->position++;
            }
            $lowerPriorityHeaderMenu->saveQuietly();
        }
    }

    /**
     * Handle the HeaderMenu "deleted" event.
     *
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return void
     */
    public function deleted(HeaderMenu $headerMenu)
    {
        $lowerPriorityHeaderMenus = HeaderMenu::where('parent', $headerMenu->parent)
            ->where('position', '>', $headerMenu->position)
            ->get();

        foreach ($lowerPriorityHeaderMenus as $lowerPriorityHeaderMenu) {
            $lowerPriorityHeaderMenu->position--;
            $lowerPriorityHeaderMenu->saveQuietly();
        }
    }

    /**
     * Handle the HeaderMenu "restored" event.
     *
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return void
     */
    public function restored(HeaderMenu $headerMenu)
    {

    }

    /**
     * Handle the HeaderMenu "force deleted" event.
     *
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return void
     */
    public function forceDeleted(HeaderMenu $headerMenu)
    {
        //
    }
}
