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

        $user = App\User::where('name', 'admin')->first();

        foreach (range(1,20) as $index) {

            $place = Place::create([
                'title' => $faker->sentence(rand(1, 2), true),
                'description' => $faker->text,
                'thumbnail' => $faker->imageUrl(350, 250),
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'price' => $faker->numberBetween(400, 1000),
                'postal_code' => $faker->postcode,
                'latitude' => rand(480000, 485000) / 10000,
                'longitude' => rand(-710000, -723000) / 10000,
                'user_id' => $user->id
            ]);
        }
    }
}
