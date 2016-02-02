<?php

use Illuminate\Database\Seeder;

class Locales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'English',
                'code' => 'En_US',
                'active' => 1,
                'default' => 1,
            ],
            [
                'title' => 'Russian',
                'code' => 'Ru_RU',
                'active' => 1,
                'default' => 0,
            ]
        ];

        foreach ($data as $locale) {
            \App\Models\Locale::create($locale)->save();
        }
    }
}
