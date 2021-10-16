<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::factory(40)->create()->each(function ($task) {
            $task->save();

            foreach ($this->getTag() as $tag) {
                $task->tags()->sync($tag->id);
            }
        });
    }

    private function getTag()
    {
        $tagAll = Tag::all();

        return $tagAll->random(1, count($tagAll));
    }
}
