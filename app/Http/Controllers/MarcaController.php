<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $registros = Marca::where('nombre', 'LIKE', '%'.$texto.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('marca.index', compact(['registros', 'texto']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marca = new Marca();
        return view('marca.action', compact('marca'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $registro = new Marca();
        $registro->nombre = $request->input('nombre');
        $registro->save();
        return redirect()->route('marca.index')->with('mensaje', 'Registro '.$registro->nombre.' creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        return view('marca.action', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $registro = Marca::findOrFail($id);
            $registro->nombre = $request->input('nombre');
            $registro->save();
            return redirect()->route('marca.index')->with('mensaje', 'Registro '.$registro->nombre.' actualizado satisfactoriamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('marca.index')->with('error', 'No se puede actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $registro = Marca::findOrFail($id);
            $registro->delete();
            return redirect()->route('marca.index')->with('mensaje', 'Registro '.$registro->nombre.' eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('marca.index')->with('error', 'No se puede eliminar el registro '.$registro->nombre.' porque está siendo usado.');
        }
    }
}