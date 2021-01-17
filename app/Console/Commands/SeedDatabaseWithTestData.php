<?php

namespace App\Console\Commands;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedDatabaseWithTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-test
                            {usersCount=100 : Count of users to create}
                            {recipesCount=1000 : Count of recipes to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with test data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $startTime = now();
        $usersCount = $this->argument('usersCount');
        $recipesCount = $this->argument('recipesCount');

        DB::transaction(function () use ($usersCount, $recipesCount) {
            DB::unprepared('SET FOREIGN_KEY_CHECKS = 0;');

            User::on()->truncate();
            Recipe::on()->truncate();

            $users = User::factory()->count($usersCount)->make();
            foreach ($users->chunk(500) as $usersChunk) {
                User::on()->insert($usersChunk->toArray());
            }

            $recipes = Recipe::factory()->count($recipesCount)->make();
            foreach ($recipes->chunk(500) as $recipesChunk) {
                Recipe::on()->insert($recipesChunk->toArray());
            }
        });

        $totalTime = now()->diffAsCarbonInterval($startTime)->totalSeconds . 's';
        $this->line("Total time: $totalTime");
        $this->info("Database seeding with test data completed successfully.");
    }
}
