<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ReportFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mueve los archivos de local a Google Storage';

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
     * @return int
     */
    public function handle()
    {
        $exams = \App\Exam::orderByDesc('id')->whereNotNull
        ('path')->get();
        foreach($exams as $exam) {
               
            $nombres = explode('/',$exam->path);
            $name = end($nombres);
            $namecomienzo = reset($nombres);
            if($namecomienzo=='https:')
            {
            echo $name."\n";
            
            // $file = asset('storage/reports/'.$name);
            $file = Storage::disk('public')->get('reports/'.$name);
            Storage::disk('gcs')->put('siremx/reports/'.$name, $file);
            $exam->update(['path' => 'siremx/reports/'.$name]);
            }
            
        }
        return 0;
    }
}
