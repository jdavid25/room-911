<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('status')->insert([
            'name' => 'active'
        ]);

        DB::table('status')->insert([
            'name' => 'deleted'
        ]);

        DB::table('status')->insert([
            'name' => 'locked'
        ]);

        DB::table('status')->insert([
            'name' => 'success'
        ]);

        DB::table('status')->insert([
            'name' => 'wrong'
        ]);

        DB::table('departments')->insert([
            'name' => 'department 1',
            'status_id' => 1
        ]);

        DB::table('departments')->insert([
            'name' => 'department 2',
            'status_id' => 1
        ]);

        DB::table('departments')->insert([
            'name' => 'department 3',
            'status_id' => 1
        ]);

        DB::table('modules')->insert([
            'name' => 'room 911',
            'status_id' => 1
        ]);

        // Role::create(['name' => 'admin']);
        Role::create(['name' => 'admin_room_911']);
        // Role::create(['name' => 'user']);
        // Role::create(['name' => 'user_room_911']);
/* 
        DB::table('roles')->insert([
            'name' => 'admin'
        ]);

        DB::table('roles')->insert([
            'name' => 'admin_room_911'
        ]);

        DB::table('roles')->insert([
            'name' => 'user'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        ]); */

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
