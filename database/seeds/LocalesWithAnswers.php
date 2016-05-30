<?php

use Illuminate\Database\Seeder;

class LocalesWithAnswers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Locale::truncate();
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'title' => $faker->country,
                'code' => $faker->locale,
                'active' => 0,
                'default' => 0,
            ];
        }

        $data[] = [
            'title' => 'English',
            'code' => 'en_US',
            'description' => 'Answers from American Movies',
            'active' => 1,
            'default' => 1,
        ];

        foreach ($data as $locale) {
            $localeModel = \App\Models\Locale::create($locale)->save();
            if ($localeModel->code !== 'en_US') {
                for ($t = 0; $t < 10; $t++) {
                    $localeModel->addAnswer(['text' => $faker->text('100')])->save();
                }
            }
        }
    }
}
