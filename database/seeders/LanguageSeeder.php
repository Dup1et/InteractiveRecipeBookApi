<?php

namespace Database\Seeders;

use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
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

            Language::on()->truncate();

            $now = Carbon::now()->toDateTimeString();

            Language::on()->insert([
               [
                   'tag' => 'ru-RU',
                   'name' => 'Русский',
                   'created_at' => $now,
                   'updated_at' => $now,
               ],
               [
                   'tag' => 'en-GB',
                   'name' => 'English (United Kingdom)',
                   'created_at' => $now,
                   'updated_at' => $now,
               ],
            ]);
        });
    }
}
