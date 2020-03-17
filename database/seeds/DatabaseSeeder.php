<?php

use App\Category;
use App\ProductModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(CategoriesTableSeeder::class);
      $this->call(ProduictTable::class);

    }
}
