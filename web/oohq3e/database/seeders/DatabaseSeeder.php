<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room')->insert([
            'id' => 1,
            'name' => 'Living Room'
        ]);
       for ($i = 1; $i <= 24; $i++){
           DB::table('esp_sensor_data')->insert([
               'room_id' => 1,
               'humidity' => 35,
               'temperature' => 20,
               'created_at' => Carbon::create(2023,2,1,$i,0,0,'GMT+1'),
               'updated_at' => Carbon::create(2023,2,1,$i,0,0,'GMT+1')
           ]);
       }


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
