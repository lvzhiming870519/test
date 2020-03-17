<?php

use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0;$i<100;$i++){
            DB::table('users')->insert([
                'name' => Str::random (10),
               // 'name' => str_random(10),
                'email' => Str::random (10).'@gmail.com',
                'password' => bcrypt('secret'),
            ]);
        }

    }
}
