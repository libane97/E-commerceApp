<?php

use App\ProductModel;
use Illuminate\Database\Seeder;

class ProduictTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 30 ; $i++) {
             ProductModel::create([
                'title' => $faker->sentence(3),
                'slug' => $faker->slug,
                'subtitle' => $faker->sentence(3),
                'description' => $faker->text,
                'price' => $faker->numberBetween(15, 300) * 100,
                'image' => 'https://via.placeholder.com/200x250'
             ])->categories()->attach([
                rand(1, 4),
                rand(1, 4)
             ]);
        }
    }
}
