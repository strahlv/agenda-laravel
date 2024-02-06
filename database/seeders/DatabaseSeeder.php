<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
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
        // User::factory(10)->create();
        User::factory()->create(['name' => 'caio', 'email' => 'caio@email.com', 'password' => '123456']);
        User::factory()->create(['name' => 'caioribeiro', 'email' => 'caio.ribeiro@saeb.ba.gov.br', 'password' => 'senha']);
        // Event::create(['title' => 'Abertura Carnaval 2024', 'date' => Carbon::create(2024, 2, 8), 'user_id' => 1]);
        // Event::create(['title' => 'Meu Aniversário', 'date' => Carbon::create(2024, 3, 21), 'user_id' => 1]);
        // Event::create(['title' => 'Payday', 'date' => Carbon::create(2024, 2, 29), 'user_id' => 2]);
        Event::factory(7)->create(['user_id' => 1]);
        Event::factory(3)->create(['user_id' => 2]);
    }
}
