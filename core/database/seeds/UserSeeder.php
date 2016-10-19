<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fname' => 'Admin',
            'lname' => 'Admin',
            'email' => 'sep@sliit.lk',
            'password' => \App\Http\Utils\Encryptions::getPassword("123"),
            'gender' => 1,
            'priority' => 1,
            'role' => 5,
            'verified' => true,
            'active' => true,
        ]);
    }
}
