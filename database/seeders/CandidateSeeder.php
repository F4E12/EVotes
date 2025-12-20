<?php

namespace Database\Seeders;

use App\Http\Controllers\CandidateController;
use Illuminate\Database\Seeder;
use App\Models\Candidate;
use App\Models\Room;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $rooms = Room::all();

        $photoUrls = [
            'https://wiki.teamfortress.com/w/images/3/3d/Icon_Saxton_Hale.png',
            'https://wiki.teamfortress.com/w/images/1/13/Icon_engineer_blue.jpg',
            'https://wiki.teamfortress.com/w/images/1/13/Icon_scout.jpg',
            'https://wiki.teamfortress.com/w/images/6/68/Icon_sniper_blue.jpg',
            'https://wiki.teamfortress.com/w/images/c/c1/Icon_soldier.jpg',
            'https://wiki.teamfortress.com/w/images/4/45/Icon_soldier_blue.jpg',
        ];

        if ($rooms->isNotEmpty()) {
            foreach ($rooms as $room) {
                for ($i = 1; $i <= 3; $i++) {
                    Candidate::create([
                        'candidate_id' => CandidateController::generateCandidateID(),
                        'room_id' => $room->id,
                        'name' => $faker->name,
                        'photo_url' => $faker->randomElement($photoUrls),
                        'vision' => $faker->paragraph(2),
                        'mission' => $faker->paragraph(3),
                    ]);
                }
            }
        } else {
            $this->command->info('No rooms found. Please run RoomSeeder first.');
        }
    }
}
