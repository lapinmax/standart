<?php

use Illuminate\Database\Seeder;

class ZodiacsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run () {
        $zodiacs = [
            '♑Capricorn', '♒Aquarius', '♓Pisces', '♈Aries', '♉Taurus', '♊Gemini', '♋Cancer', '♌Leo', '♍Virgo', '♎Libra',
            '♏Scorpio', '♐Sagittarius'
        ];

        foreach ($zodiacs as $zodiac) {
            \App\Zodiac::create([
                'title' => $zodiac,
            ]);
        }
    }
}
