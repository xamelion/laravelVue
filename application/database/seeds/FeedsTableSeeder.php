<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Feed;

class FeedsTableSeeder extends Seeder
{
    /**
     * Run the feed seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('feeds')->delete();

        // Read json
        $j = file_get_contents( __DIR__ . DIRECTORY_SEPARATOR . '../../resources/json/database.json' );
        // Decode json
        $data = json_decode($j);

        $categories = Category::all();
        $categoryId = [];

        for($i = 0; $i < count($categories); $i++) {
            $categoryId[$categories[$i]->title] = $categories[$i]->id;
        }

        for($i = 0; $i < count($data); $i++) {

            $feedData = $data[$i];
            $feed = [
                'title' => $feedData->title,
                'slug' => $feedData->slug,
                'content' => $feedData->content
            ];

            // Parse content
            if (isset($feedData->content[0]->content)) {
                $feed['content'] = $feedData->content[0]->content;
            }

            // Parse media
            if (isset($feedData->media[0]->media->attributes->url)) {
                $feed['media'] = $feedData->media[0]->media->attributes->url;
            }

            // Parse category
            $feed['category_id'] = isset($feedData->categories->primary) ?
                $categoryId[$feedData->categories->primary] :
                $categoryId[$feedData->categories->additional[0]];


            Feed::create($feed);
        }


    }
}