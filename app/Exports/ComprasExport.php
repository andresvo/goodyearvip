<?php

namespace App\Exports;

use App\Compra;
use DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ComprasExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
	public $id_empresa = null;

	public function array(): array
    {
		$where = '';
		if($this->id_empresa != null) $where = ' WHERE tarjeta.id_empresa = ' . intval($this->id_empresa);

		$compras = DB::select( DB::raw("SELECT usuario.email, medida.nombre AS mnombre, producto.nombre AS pnombre, cantidad, tarjeta.codigo, compra.created_at, precio, boleta, factura, medida.sku FROM compra JOIN usuario ON compra.id_usuario = usuario.id JOIN medida ON compra.id_medida = medida.id JOIN producto ON medida.id_producto = producto.id JOIN tarjeta ON compra.id_tarjeta = tarjeta.id $where ORDER BY compra.id DESC") );
		
		foreach($compras as $c) {
			$sheet[] = [$c->email, $c->pnombre, $c->mnombre, $c->cantidad, $c->codigo, $c->precio, $c->boleta, $c->factura, $c->created_at, $c->sku];
		}

		return $sheet;
	}
	
	public function headings(): array
    {
        return ['Usuario', 'Diseño', 'Medida', 'Cantidad', 'Tarjeta', 'Precio unitario (precio a público vigente este mes)', 'Boleta', 'Factura', 'Fecha creación', 'SKU Goodyear'];
	}
	
	public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:I1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }
}
