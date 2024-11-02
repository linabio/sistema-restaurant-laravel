<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Mesa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $pedidos = Pedido::with(['cliente', 'empleado', 'mesa'])
            ->whereHas('cliente', function ($query) use ($texto) {
                $query->where('nombre', 'LIKE', '%'.$texto.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('pedido.index', compact('pedidos', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $empleados = Empleado::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $mesas = Mesa::select('id', 'numero')->orderBy('numero', 'asc')->get();

        return view('pedido.create', compact('clientes', 'empleados', 'mesas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'empleado_id' => 'required|exists:empleados,id',
            'mesa_id' => 'required|exists:mesas,id',
            'estado' => 'required|string|max:20',
            'total' => 'required|numeric|min:0',
        ]);

        $pedido = Pedido::create($validatedData);

        return redirect()->route('pedido.index')->with('mensaje', 'Pedido creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'empleado', 'mesa', 'detalles.producto'])->findOrFail($id);

        return view('pedido.show', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $clientes = Cliente::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $empleados = Empleado::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $mesas = Mesa::select('id', 'numero')->orderBy('numero', 'asc')->get();

        return view('pedido.edit', compact('pedido', 'clientes', 'empleados', 'mesas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'empleado_id' => 'required|exists:empleados,id',
            'mesa_id' => 'required|exists:mesas,id',
            'estado' => 'required|string|max:20',
            'total' => 'required|numeric|min:0',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->update($validatedData);

        return redirect()->route('pedido.index')->with('mensaje', 'Pedido actualizado satisfactoriamente.');
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