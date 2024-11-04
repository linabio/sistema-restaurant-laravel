<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Mesa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BoletaController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $registros = Pedido::with(['cliente', 'empleado'])
            ->whereHas('cliente', function ($query) use ($texto) {
                $query->where('nombre', 'LIKE', '%'.$texto.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('pedido.index', compact('registros', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pedido = new Pedido();
        $clientes = Cliente::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $empleados = Empleado::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $mesas = Mesa::select('id', 'numero')->orderBy('numero', 'asc')->get();

        return view('pedido.action', compact('pedido', 'clientes', 'empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'empleado_id' => 'required|exists:empleados,id',
            'estado' => 'required|integer|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        $registro = Pedido::create($validatedData);

        return redirect()->route('pedido.index')->with('mensaje', 'Pedido creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show (Pedido $pedido)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $clientes = Cliente::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $empleados = Empleado::select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        return view('pedido.action', compact('pedido', 'clientes', 'empleados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {  
        try {
            $registro = Pedido::findOrFail($id);
            $registro->cliente_id = $request->input('cliente_id');
            $registro->empleado_id = $request->input('empleado_id');
            $registro->estado= $request->input('estado');
            $registro->total = $request->input('total');
            $registro->save();
            return redirect()->route('pedido.index')->with('mensaje', 'Pedido actualizado satisfactoriamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('pedido.index')->with('error', 'No se puede actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pedido = Pedido::findOrFail($id);
            $pedido->delete();

            return redirect()->route('pedido.index')->with('mensaje', 'Pedido eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('pedido.index')->with('error', 'No se puede eliminar el pedido porque está siendo usado.');
        }
    }
}