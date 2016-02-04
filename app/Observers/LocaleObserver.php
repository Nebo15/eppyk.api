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
        $locale->active = (bool)$locale->active;
        $locale->default = (bool)$locale->default;
        if ($locale->default === true) {
            Locale::all()->each(function($data){$data->default = false; $data->save();});
        }
    }
}
