<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Log;
use App\Models\User;
use App\Services\Spotify;

class GenerateCharts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chart:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate charts for all users who want to have updated charts';

    protected $spotify;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Spotify $spotify)
    {
        parent::__construct();

        $this->spotify = $spotify;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting chart generation...');
        // get all users who want updated charts
        $users = User::all();

        $bar = $this->output->createProgressBar(count($users));

        foreach ($users as $user) {
            $this->spotify->generateChart($user);

            $this->info('Chart for ' . $user->name . ' generated successfully!');

            $bar->advance();
        }

        $bar->finish();

        $this->info(PHP_EOL . 'All charts generated successfully!');
        Log::info('[Commands\GenerateCharts] All charts generated successfully!');
    }
}
