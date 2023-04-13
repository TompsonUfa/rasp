<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SchedulesImport;

class ImportExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $id;
    /**
     * Create a new job instance.
     */
    public function __construct($file, $id)
    {
        $this->file = $file;
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(new SchedulesImport($this->id), $this->file);
    }
}
