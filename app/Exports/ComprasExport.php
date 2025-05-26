<?php

namespace App\Exports;

use App\Models\Compra;
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
		$compras = Compra::join('usuario', 'compra.id_usuario', '=', 'usuario.id')
			->join('medida', 'compra.id_medida', '=', 'medida.id')
			->join('producto', 'medida.id_producto', '=', 'producto.id')
			->join('tarjeta', 'compra.id_tarjeta', '=', 'tarjeta.id')
			->whereRaw('YEAR(compra.created_at) > 2021');
		if($this->id_empresa != null) $compras->where('tarjeta.id_empresa', '=', $this->id_empresa);

		$compras = $compras->orderBy('compra.id', 'DESC')
			->select('usuario.email', 'medida.nombre AS mnombre', 'producto.nombre AS pnombre', 'cantidad', 'tarjeta.codigo', 'compra.created_at', 'precio', 'boleta', 'factura', 'medida.sku')
			->get();
		foreach($compras as $c) {
			$sheet[] = [$c->email, $c->pnombre, $c->mnombre, $c->cantidad, $c->codigo, $c->precio, $c->boleta, $c->factura, $c->created_at, $c->sku, round($c->precio * 0.12)];
		}

		return $sheet;
	}
	
	public function headings(): array
    {
        return ['Usuario', 'Diseño', 'Medida', 'Cantidad', 'Tarjeta', 'Precio unitario (precio a público vigente este mes)', 'Boleta', 'Factura', 'Fecha creación', 'SKU Goodyear', '12% de apoyo'];
	}
	
	public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:K1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }
}
