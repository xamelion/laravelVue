<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the category seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryPull = [];

        // Read json
        $j = file_get_contents( __DIR__ . DIRECTORY_SEPARATOR . '../../resources/json/database.json' );
        // Decode json
        $data = json_decode($j);
        // Select all categories
        for ($i = 0; $i < count($data); $i++) {
            $categories  = $data[$i]->categories;
            if (isset($categories->primary)) {
                array_push($categoryPull, $categories->primary);
            }
            $categoryPull = array_merge($categoryPull, $categories->additional);
        }
        $categoryPull = array_values(array_unique($categoryPull));

        DB::table('categories')->delete();

        for ($i = 0; $i < count($categoryPull); $i++) {
            Category::create(['title' => $categoryPull[$i]]);
        }

    }
}