<?php

use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range(1,20) as $index) {
            $place = Place::create([
                'title' => $faker->sentence(rand(4, 10), true),
                'description' => $faker->text,
                'thumbnail' => $faker->imageUrl(1800, 560),
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'postal_code' => $faker->postcode,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'owner_name' => $faker->firstName,
                'owner_email' => $faker->email
            ]);
        }
    }
}
