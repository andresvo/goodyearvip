<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tarjeta;
use App\Models\Diseno;
use App\Models\Empresa;
use ZipArchive;

class CrearImagenes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tarjetas:imagenes {id_empresa} {desde} {cantidad} {id_diseno}';

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
        $id_empresa = $this->argument('id_empresa');
        $desde = $this->argument('desde');
        $cantidad = $this->argument('cantidad');
        $id_diseno = $this->argument('id_diseno');
        $empresa = Empresa::find($id_empresa);
		$codigo = 'GY' . str_pad($desde, 4, '0', STR_PAD_LEFT) . $empresa->sufijo;
		$tarjetas = Tarjeta::where('tipo', 1)->where('id_empresa', $id_empresa)
		    ->where('numero', '>=', $desde)->take($cantidad)->get();
		$diseno = Diseno::find($id_diseno);
		$resp = [];
		$fuente = storage_path('app/tarjeta/OpenSans-SemiBold.ttf');
		foreach($tarjetas as $index => $tarjeta) {
			$im = imagecreatefrompng(storage_path('app/' . $diseno->archivo));
			$negro = imagecolorallocate($im, 0, 0, 0);
			imagettftext($im, 24, 0, 350 , 223, $negro, $fuente, $tarjeta->codigo);
			imagepng($im, storage_path('app/public/' . $tarjeta->codigo . '.png'));
			imagedestroy($im);
			$resp[] = $tarjeta->codigo;
            $porcentaje = round(($index + 1) * 100 / count($tarjetas));
            file_put_contents(storage_path('logs/bg.log'), $porcentaje);
		}
		$zip = new ZipArchive;
		if ($zip->open(storage_path('app/public/tarjetas.zip'), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
			foreach($resp as $filename) {
				$zip->addFile(storage_path('app/public/' . $filename . '.png'), $filename . '.png');
			}
			$zip->close();
			foreach($resp as $filename) {
				unlink(storage_path('app/public/' . $filename . '.png'));
			}
		}
        return 0;
    }
}
