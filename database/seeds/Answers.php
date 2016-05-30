<?php

use Illuminate\Database\Seeder;

class Answers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(__DIR__.'/answers.csv', "r")) !== false) {
            $locale = \App\Models\Locale::findByLocale('en_US');
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $data = array_map('trim', $data);
                $locale->addAnswer([
                    'text' => $data[0],
                    'author' => $data[1] . ', ' . $data[2] . ', ' . $data[3] . ', ' . $data[4]
                ])->save();
            }
            fclose($handle);
        }
    }
}
