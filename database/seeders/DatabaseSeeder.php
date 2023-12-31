<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create([
            'name' => 'Admin',
        ]);

        \App\Models\Role::create([
            'name' => 'Pimpinan',
        ]);

        \App\Models\Role::create([
            'name' => 'Staff',
        ]);

        \App\Models\Role::create([
            'name' => 'Dosen',
        ]);

        \App\Models\User::create([
            'name' => 'Solikin',
            'nip' => '11210910000011',
            'email' => 'solikin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'role_id' => 1
        ]);

        \App\Models\User::create([
            'name' => 'Ir. Nashrul Hakim',
            'nip' => '11210910000011',
            'email' => 'antoni2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'role_id' => 2
        ]);


        \App\Models\User::create([
            'name' => 'Fitri Mitrasih',
            'nip' => '11210910000011',
            'email' => 'antoni3@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'role_id' => 3
        ]);


        \App\Models\User::create([
            'name' => 'Dewi Khairani',
            'nip' => '11210910000011',
            'email' => 'antoni4@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'role_id' => 4
        ]);
    }
}
