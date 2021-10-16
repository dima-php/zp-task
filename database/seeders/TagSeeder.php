<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{

    private $tags = ['Pending', 'In progress', 'Testing', 'Done'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->tags as $tag) {
            Tag::query()
                ->create([
                    'name' => $tag,
                ]);
        }
    }
}
