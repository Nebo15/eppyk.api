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
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i<5; $i++) {
            $data[] = [
                'title' => $faker->country,
                'code' => $faker->locale,
                'active' => 1,
                'default' => 0,
            ];
        }
        foreach ($data as $locale) {
            $localeModel = \App\Models\Locale::create($locale)->save();
            for ($t = 0; $t < 10; $t++) {
                $localeModel->addAnswer(['text'=>$faker->text('100')])->save();
            }
        }
    }
}
