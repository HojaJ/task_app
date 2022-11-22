<?php

namespace App\Console\Commands;

use App\Http\Controllers\TemperatureSeedController;
use Illuminate\Console\Command;

class SeedTemperature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:temperature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding temperature table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $temperature = new TemperatureSeedController;
        echo $temperature->seed_table();
    }
}
