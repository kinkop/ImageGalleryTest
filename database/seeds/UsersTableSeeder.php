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
        \ImageGallery\User::create([
            'name' => 'Pakin Mankong',
            'email' => 'pakinmankong@gmail.com',
            'password' => \Hash::make('371985')
        ]);
    }
}
