<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tarjeta;
use App\Models\Diseno;
use App\Models\Empresa;
use ZipArchive;
use TCPDF;

class CrearPdfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tarjetas:pdf {id_empresa} {desde} {cantidad} {id_diseno}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera pdf de tarjetas';

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

        foreach($tarjetas as $index => $tarjeta) {
            $pdf = new TCPDF('L', 'mm', array(144,94), true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Cliente VIP Goodyear');
            $pdf->SetTitle('Tarjeta Cliente VIP Goodyear');
            $pdf->SetSubject('Tarjeta Cliente VIP Goodyear');
            $pdf->SetKeywords('Tarjeta, Cliente, VIP, Goodyear');

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(0, 0, 0, true); // Establece los márgenes izquierdo, superior y derecho a 0
            $pdf->SetAutoPageBreak(false, 0); // Establece el margen inferior a 0

            $pdf->setImageScale(2);

            $pdf->setFontSubsetting(true);

            $pdf->SetFont('dejavusans', '', 14, '', true);
            $pdf->AddPage();

            $img_file = storage_path('app/' . $diseno->archivo);
            $pdf->Image($img_file, 0, 0, 144, 94, '', '', '', false, 300, '', false, false, 0, true, false, true);
            $pdf->SetY(40);
            $pdf->SetX(70);
            $pdf->Cell(60, 0, $tarjeta->codigo, 0, 0, 'C', 0, '', 0, false, 'T', 'M');

            $pdf->Output(storage_path('app/public/' . $tarjeta->codigo . '.pdf'), 'F');

            $resp[] = $tarjeta->codigo;
            $porcentaje = round(($index + 1) * 100 / count($tarjetas));
            file_put_contents(storage_path('logs/bg.log'), $porcentaje);
        }

        $zip = new ZipArchive;
        if ($zip->open(storage_path('app/public/tarjetas.zip'), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach($resp as $filename) {
                $zip->addFile(storage_path('app/public/' . $filename . '.pdf'), $filename . '.pdf');
            }
            $zip->close();
            foreach($resp as $filename) {
                unlink(storage_path('app/public/' . $filename . '.pdf'));
            }
        }

        return 0;
    }
}
