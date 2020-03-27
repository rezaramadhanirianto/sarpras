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
        App\Model\Users::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('secret'),
            'room_id' => 0,
            'roles' => 1,
            'status' => 1,


        ]);

        App\Model\Satuan::create([
            'satuan' => 'buah',
        ]);

        App\Model\Room::create([
            'room' => '201',
        ]);

        App\Model\Users::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('secret'),
            'room_id' => 1,
            'roles' => '0',
            'status' => 1,
        ]);
    }
}
