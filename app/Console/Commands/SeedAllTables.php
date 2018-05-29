<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class SeedAllTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iseed:all {--chunk=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extensão do comando issed para todas as tabelas';

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
        if(!is_dir(database_path('seeds'))){
            $this->error('Não há pasta seed ou DatabaseSeed');
            return;
        }

        $tables = collect(DB::select('SHOW TABLES'));
        $this->line('Total de tabelas: '. $tables->count());


        $groups = $tables->map(function($table){
            return $table->Tables_in_{{ env('APP_NAME') }}v2;
        })->chunk($this->option('chunk'));

        $groups->each(function($group){
            $nameTables = collect($group)->implode(',');
            $this->line('Seeds a serem geradas: '. $nameTables);
            \Artisan::call('iseed', ['tables' => $nameTables]);

        });
        return;
    }
}
