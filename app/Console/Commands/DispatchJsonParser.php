<?php


namespace App\Console\Commands;


use App\Jobs\InsertEachJson;
use Illuminate\Console\Command;

class DispatchJsonParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "json:parse";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pick the last few files and parse';

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
     */
    public function handle()
    {
        dispatch((new InsertEachJson()));
    }
}
