<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\TipoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $registros = Producto::with(['marca', 'tipoProducto'])
            ->where('nombre', 'LIKE', '%'.$texto.'%')
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('producto.index', compact(['registros', 'texto']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $producto = new Producto();
        $marcas = Marca::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $tiposProducto = TipoProducto::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('producto.action', compact('producto', 'marcas', 'tiposProducto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:1000',
            'precio_unitario' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'marca_id' => 'required|exists:marcas,id',
            'tipo_producto_id' => 'required|exists:tipos_producto,id',
        ]);

        $registro = Producto::create($validatedData);

        return redirect()->route('producto.index')->with('mensaje', 'Registro '.$registro->nombre.' creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $marcas = Marca::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $tiposProducto = TipoProducto::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return view('producto.action', compact(['producto', 'marcas', 'tiposProducto']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $registro = Producto::findOrFail($id);
            $registro->nombre = $request->input('nombre');
            $registro->descripcion = $request->input('descripcion');
            $registro->precio_unitario = $request->input('precio_unitario');
            $registro->stock = $request->input('stock');
            $registro->marca_id = $request->input('marca_id');
            $registro->tipo_producto_id = $request->input('tipo_producto_id');
            $registro->save();
            return redirect()->route('producto.index')->with('mensaje', 'Registro '.$registro->nombre.' actualizado satisfactoriamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('producto.index')->with('error', 'No se puede actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $registro = Producto::findOrFail($id);
            $registro->delete();
            return redirect()->route('producto.index')->with('mensaje', 'Registro '.$registro->nombre.' eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('producto.index')->with('error', 'No se puede eliminar el registro '.$registro->nombre.' porque está siendo usado.');
        }
    }
}