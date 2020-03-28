<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Select all categories
        $this->call(CategoriesTableSeeder::class);
        $this->call(FeedsTableSeeder::class);
    }
}
