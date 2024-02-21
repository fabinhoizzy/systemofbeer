<?php

namespace Database\Seeders;

use App\Enums\PanelTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'panel' => PanelTypeEnum::ADMIN,
            'password' => bcrypt('password')
        ]);
    }
}
