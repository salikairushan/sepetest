<?php

namespace App\Console\Commands;

use App\Cookies;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteCookies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookie:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the expired cookies';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $cookies  = Cookies::where('time_period','<',Carbon::now())->delete();
        $this->info('Cookies Delete cron executed successfully!');
    }
}
