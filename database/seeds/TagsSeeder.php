<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsSeeder extends Seeder
{
    public function run()
    {
        $this->clear();
        $this->seed();
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();

        echo "\tErasing tags\n";
        DB::table('tags')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function seed()
    {
        $tags = $this->getTags();
        foreach ($tags as $t) {
            $tag = new Tag();
            $tag->key = $tag->makeKey($t);
            $tag->value = $t;
            $tag->published = true;
            $tag->save();

            echo "\tTag '{$t}' created.\n";
        }
    }

    private function getTags()
    {
        return [
            'Arte',
            'Biologia',
            'Ciências',
            'Educação Física',
            'Ensino Religioso',
            'Filosofia',
            'Física',
            'Geografia',
            'História',
            'Língua Portuguesa',
            'Matemática',
            'Química',
            'Sociologia',
        ];
    }
}
