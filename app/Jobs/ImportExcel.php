<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SchedulesImport;

class ImportExcel implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;
    private $id;
    private $filter;
    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $id, $filter)
    {
        $this->file = $filePath;
        $this->id = $id;
        $this->filter = $filter;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(new SchedulesImport($this->id, $this->filter), $this->file);
    }
}
