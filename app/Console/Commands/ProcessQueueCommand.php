<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessQueueJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ProcessQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
       $this->info("start schedule");
        if (Cache::has('artisan'))
        {
            $this->info("cache has");
            ProcessQueueJob::dispatch();
        } else {
            $this->info("artisan call");
            ProcessQueueJob::dispatch();
            try{
                Artisan::call('queue:work');
            } catch (\Error $e){
                
            }
           
        }
    }
}
