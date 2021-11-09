<?php

use App\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(Skill::class)->create(['name' => 'HTML']);
        Factory(Skill::class)->create(['name' => 'CSS']);
        Factory(Skill::class)->create(['name' => 'JS']);
        Factory(Skill::class)->create(['name' => 'PHP']);
        Factory(Skill::class)->create(['name' => 'SQL']);
        Factory(Skill::class)->create(['name' => 'POO']);
        Factory(Skill::class)->create(['name' => 'TDD']);
    }
}
