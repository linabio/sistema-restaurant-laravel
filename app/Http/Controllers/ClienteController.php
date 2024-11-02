<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $registros = Cliente::where('nombre', 'LIKE', '%'.$texto.'%')
            ->orWhere('apellido', 'LIKE', '%'.$texto.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('cliente.index', compact(['registros', 'texto']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cliente = new Cliente();
        return view('cliente.action', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $registro = new Cliente();
        $registro->id = $request->input('id');
        $registro->nombre = $request->input('nombre');
        $registro->apellido = $request->input('apellido');
        $registro->save();
        return redirect()->route('cliente.index')->with('mensaje', 'Registro '.$registro->nombre.' creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.action', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $registro = Cliente::findOrFail($id);
            $registro->nombre = $request->input('nombre');
            $registro->apellido = $request->input('apellido');
            $registro->save();
            return redirect()->route('cliente.index')->with('mensaje', 'Registro '.$registro->nombre.' actualizado satisfactoriamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('cliente.index')->with('error', 'No se puede actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $registro = Cliente::findOrFail($id);
            $registro->delete();
            return redirect()->route('cliente.index')->with('mensaje', 'Registro '.$registro->nombre.' eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('cliente.index')->with('error', 'No se puede eliminar el registro '.$registro->nombre.' porque está siendo usado.');
        }
    }
}