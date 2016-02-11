<?php
namespace App\Observers;

use App\Models\Locale;

class LocaleObserver
{
    /**
     * @param \App\Models\Locale $locale
     */
    public function saving($locale)
    {
        if ($locale->default === true) {
            if ($locale->isDirty('default')) {
                Locale::where(Locale::PRIMARY_KEY, '!=', $locale->getId())
                    ->update(['default' => false])
                ;
            }
        }
    }
}
