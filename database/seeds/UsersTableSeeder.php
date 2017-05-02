<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert a test App user
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '123456789',
            'email' => 'test@test.com',
            'password' => bcrypt('qwerty'),
            'address_street' => '',
            'address_city' => '',
            'address_postcode' => '',
            'address_state' => ''
        ]);
    }
}
