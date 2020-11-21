<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            DB::unprepared('SET FOREIGN_KEY_CHECKS = 0;');

            User::on()->truncate();

            $faker = Factory::create();
            $now = Carbon::now()->toDateTimeString();

            for ($i = 0; $i < 10; $i++) {
                User::on()->insert([
                    'username' => $faker->userName,
                    'password' => Hash::make('1q2w3e'),
                    'language_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        });
    }
}
