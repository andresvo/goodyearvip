<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrearImagenes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tarjetas:imagenes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera imágenes de tarjetas';

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
        sleep(5);
        file_put_contents(storage_path('logs/bg.log'), date('c'));
        return 0;
    }
}
