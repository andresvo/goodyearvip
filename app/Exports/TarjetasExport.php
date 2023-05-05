<?php

namespace App\Exports;

use App\Models\Tarjeta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TarjetasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	public $id_empresa = null;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		return Tarjeta::join('empresa', 'empresa.id', '=', 'tarjeta.id_empresa')->where('id_empresa', $this->id_empresa)->orderBy('numero')
		->select('empresa.nombre', 'numero', 'codigo', 'tarjeta.created_at', 'cupo_inicial', 'cupo_actual')->get();
	}
	
	public function headings(): array
    {
        return ['Empresa', 'Número', 'Código', 'Fecha creación', 'Cupo inicial', 'Cupo actual'];
	}
	
	public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:F1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }
}
