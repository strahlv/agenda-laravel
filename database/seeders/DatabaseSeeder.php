<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\UserSetting;
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
        User::factory()->has(UserSetting::factory(), 'settings')->create(['name' => 'caio', 'email' => 'caio@email.com', 'password' => '12345678']);
        User::factory()->has(UserSetting::factory(), 'settings')->create(['name' => 'caioribeiro', 'email' => 'caio.ribeiro@saeb.ba.gov.br', 'password' => '12345678']);
        // Event::create(['title' => 'Abertura Carnaval 2024', 'date' => Carbon::create(2024, 2, 8), 'user_id' => 1]);
        // Event::create(['title' => 'Meu Aniversário', 'date' => Carbon::create(2024, 3, 21), 'user_id' => 1]);
        // Event::create(['title' => 'Payday', 'date' => Carbon::create(2024, 2, 29), 'user_id' => 2]);
        Event::factory(30)->create(['user_id' => 1]);
        Event::factory(20)->create(['user_id' => 2]);
    }
}
