<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpsertProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:upsert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update/Insert Properties';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://trial.craig.mtcserver15.com/api/properties?page[number]=1&page[size]=100&api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug');
        return $response;
        // return Command::SUCCESS;
    }
}
