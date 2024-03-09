<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'super@user.com',
            'password' => 'password',
        ]);

        /** @var \App\Models\Space $space */
        $space = $user->spaces()->create([
            'name' => $user->name,
            'updated_by_id' => $user->id,
        ]);

        $space->columns()->createMany([
            [
                'name' => 'Triage',
                'status' => 'triage',
                'order' => 0,
            ],
            [
                'name' => 'To Do',
                'status' => 'todo',
                'order' => 1,
            ],
            [
                'name' => 'Doing',
                'status' => 'doing',
                'order' => 2,
            ],
            [
                'name' => 'Done',
                'status' => 'done',
                'order' => 3,
            ],
            [
                'name' => 'Abandon',
                'status' => 'abandon',
                'order' => 4,
            ],
        ]);
    }
}
