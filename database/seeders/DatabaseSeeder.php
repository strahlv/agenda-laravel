<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\UserSetting;
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
        User::factory()->has(UserSetting::factory(), 'settings')->create(['name' => 'caio', 'email' => 'caio@email.com', 'password' => '12345678']);
        User::factory()->has(UserSetting::factory(), 'settings')->create(['name' => 'caioribeiro', 'email' => 'caio.ribeiro@saeb.ba.gov.br', 'password' => '12345678']);
        Event::factory(30)->create(['user_id' => 1]);
        Event::factory(20)->create(['user_id' => 2]);
    }
}
