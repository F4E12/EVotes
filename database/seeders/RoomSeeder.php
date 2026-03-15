<?php

namespace Database\Seeders;

use App\Http\Controllers\RoomController;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@example.com')->first();

        if (!$adminUser) {
            $this->command->info('Admin user not found. Please run UserSeeder first.');
            return;
        }

        $rooms = [
            [
                'title' => 'BEM President Election 2026',
                'description' => 'Official election for Student Executive Board president. Each student gets one vote. Results are published after the vote closes and verified by the election committee.',
                'start_date' => now()->subDays(2)->setTime(8, 0),
                'end_date' => now()->addDays(1)->setTime(17, 0),
                'is_revealed' => false,
            ],
            [
                'title' => 'Computer Science Department Chair Vote',
                'description' => 'Faculty and registered department representatives vote for the next department chair. This vote includes candidate programs, public debates, and post-election transparency report.',
                'start_date' => now()->addDays(5)->setTime(9, 0),
                'end_date' => now()->addDays(7)->setTime(16, 0),
                'is_revealed' => false,
            ],
            [
                'title' => 'Community Innovation Grant Selection',
                'description' => 'Open voting session to determine which student-led social innovation project receives this semester\'s community impact grant.',
                'start_date' => now()->subWeeks(2)->setTime(10, 0),
                'end_date' => now()->subWeeks(2)->addDays(2)->setTime(18, 0),
                'is_revealed' => true,
            ],
            [
                'title' => 'School Council Representative 2026',
                'description' => 'Annual election for school council representatives focused on budget transparency, student wellbeing, and program quality improvements.',
                'start_date' => now()->addDays(10)->setTime(8, 30),
                'end_date' => now()->addDays(12)->setTime(15, 30),
                'is_revealed' => false,
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::updateOrCreate(
                ['title' => $roomData['title']],
                [
                    'room_id' => RoomController::generateRoomID(),
                    'host_id' => $adminUser->id,
                    'description' => $roomData['description'],
                    'unique_token' => RoomController::generateToken(),
                    'share_code' => strtoupper(Str::random(8)),
                    'is_revealed' => $roomData['is_revealed'],
                    'start_date' => $roomData['start_date'],
                    'end_date' => $roomData['end_date'],
                ]
            );
        }
    }
}
