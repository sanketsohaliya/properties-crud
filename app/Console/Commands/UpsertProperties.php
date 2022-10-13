<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PropertyController;

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
        $controller = new PropertyController();
        $controller->upsert();
    }
}
