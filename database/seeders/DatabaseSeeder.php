<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => "Zoalfikar",
            'identifier' =>1111,
            'password' =>Hash::make("12345678"),
            'role'=>"admin"
        ]);
        DB::table('users')->insert([
            'name' => "Ali",
            'identifier' =>2222,
            'password' =>Hash::make("12345678"),
            'role'=>"user"
        ]);
    }
}
