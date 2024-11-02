<?php

namespace App\Http\Controllers;

use App\Models\TipoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoProductoController extends Controller
{
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $registros = TipoProducto::where('nombre', 'LIKE', '%'.$texto.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('tipo_producto.index', compact(['registros', 'texto']));
    }

    public function create()
    {
        $tipoProducto = new TipoProducto();
        return view('tipo_producto.action', compact('tipoProducto'));
    }

    public function store(Request $request)
    {
        $registro = new TipoProducto();
        $registro->nombre = $request->input('nombre');
        $registro->save();
        return redirect()->route('tipo_producto.index')->with('mensaje', 'Registro '.$registro->nombre.' creado satisfactoriamente.');
    }

    public function show(TipoProducto $tipoProducto)
    {
        //
    }

    public function edit($id)
    {
        $tipoProducto = TipoProducto::findOrFail($id);
        return view('tipo_producto.action', compact('tipoProducto'));
    }

    public function update(Request $request, $id)
    {
        try {
            $registro = TipoProducto::findOrFail($id);
            $registro->nombre = $request->input('nombre');
            $registro->save();
            return redirect()->route('tipo_producto.index')->with('mensaje', 'Registro '.$registro->nombre.' actualizado satisfactoriamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('tipo_producto.index')->with('error', 'No se puede actualizar el registro');
        }
    }

    public function destroy($id)
    {
        try {
            $registro = TipoProducto::findOrFail($id);
            $registro->delete();
            return redirect()->route('tipo_producto.index')->with('mensaje', 'Registro '.$registro->nombre.' eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('tipo_producto.index')->with('error', 'No se puede eliminar el registro '.$registro->nombre.' porque está siendo usado.');
        }
    }
}