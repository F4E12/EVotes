<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'profile_pic_url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'name' => 'Nadia Putri',
                'email' => 'nadia.putri@example.com',
                'profile_pic_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'name' => 'Rafi Pratama',
                'email' => 'rafi.pratama@example.com',
                'profile_pic_url' => 'https://images.unsplash.com/photo-1504593811423-6dd665756598?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'name' => 'Clara Wijaya',
                'email' => 'clara.wijaya@example.com',
                'profile_pic_url' => 'https://images.unsplash.com/photo-1546961329-78bef0414d7c?auto=format&fit=crop&w=400&q=80',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('12345678'),
                    'profile_pic_url' => $userData['profile_pic_url'],
                ]
            );
        }
    }
}
