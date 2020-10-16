<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
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
        // User::factory()->count(5)->has(
        //     Todo::factory()
        //         ->count(2)
        //         ->state(function (array $attributes, User $user) {
        //             return ['created_by' => $user->id];
        //         }))
        //         ->create();
        User::factory(5)->hasTodos(2)->create();
        // \App\Models\User::factory(5)->create();
        // $this->call([
        //     TodoSeeder::class,
        // ]);
    }
}
