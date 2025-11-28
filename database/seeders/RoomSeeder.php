<?php

namespace Database\Seeders;

use App\Http\Controllers\RoomController;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $adminUser = User::where('name', 'admin')->first();

        if ($adminUser) {
            for ($i = 1; $i <= 3; $i++) {
                $startDate = $faker->dateTimeBetween('-1 week', '+1 week');
                $endDate = $faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s') . ' +1 month');

                Room::create([
                    'room_id' => Str::random(10),
                    'host_id' => $adminUser->id,
                    'title' => $faker->sentence(3),
                    'description' => $faker->paragraph(3),
                    'unique_token' => Str::random(10),
                    'is_revealed' => $faker->boolean(20), // 20% chance of being revealed
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }
        } else {
            $this->command->info('Admin user not found. Please run UserSeeder first.');
        }
    }
}
