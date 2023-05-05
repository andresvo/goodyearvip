<?php

namespace App\Imports;

use App\Producto;
use App\Medida;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeImport;
use Illuminate\Support\Facades\Log;

class ProductosImport implements OnEachRow, WithEvents
{
	use Importable, RegistersEventListeners;

	public static function beforeImport(BeforeImport $event)
    {
		$affected = Producto::where('activo', 1)->update(['activo' => 0]);
		$affected = Medida::where('activo', 1)->update(['activo' => 0]);
    }

	public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

		$existente = Producto::join('medida', 'medida.id_producto', '=', 'producto.id')
		->where('producto.nombre', $row[4])
		->where('medida.nombre', $row[7])
		->select('producto.nombre AS diseno', 'producto.id AS id_producto', 'medida.nombre AS medida', 'medida.id AS id_medida')->first();

		if($existente) {
			$producto = Producto::find($existente->id_producto);
			$producto->marca = $row[3];
			$producto->activo = 1;
			$producto->save();
			$medida = Medida::find($existente->id_medida);
			$medida->sku = $row[0];
			$medida->activo = 1;
			$medida->save();
			Log::debug('existente ' . $producto->marca . ' ' . $producto->nombre . ' ' . $medida->nombre . ' ' . $medida->sku);
		} else {
			// existe producto
			$producto = Producto::where('nombre', $row[4])->first();
			if(!$producto) {
				$producto = new Producto;
				$producto->nombre = $row[4];
			}
			$producto->marca = $row[3];
			$producto->activo = 1;
			$producto->save();
			$medida = new Medida;
			$medida->sku = $row[0];
			$medida->nombre = $row[7];
			$medida->id_producto = $producto->id;
			$medida->activo = 1;
			$medida->save();
			Log::debug('nuevo ' . $producto->marca . ' ' . $producto->nombre . ' ' . $medida->nombre . ' ' . $medida->sku);
		}
    }
}
