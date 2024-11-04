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
        $mesaId = $request->route('mesa'); // Get mesa from route parameter
        $mesa = null; // Initialize mesa as null

        $pedidos = Pedido::with(['cliente', 'empleado', 'mesa']);

        if ($mesaId) {
            $mesa = Mesa::findOrFail($mesaId);
            $pedidos = $pedidos->where('id', $mesaId);
        }

        if ($texto) {
            $pedidos = $pedidos->whereHas('cliente', function ($query) use ($texto) {
                $query->where('nombre', 'LIKE', '%' . $texto . '%');
            });
        }

        $pedidos = $pedidos->orderBy('id', 'desc')->paginate(5);

        // Now $mesa will either be null or contain the mesa object
        return view('pedido.index', compact('pedidos', 'texto', 'mesa'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener el ID de la mesa desde los parámetros de la URL
        $mesaId = 1;

        // Buscar la mesa en la base de datos
        // $mesa = Mesa::findOrFail($mesaId);

        // Retornar la vista de creación de pedidos, pasando la información de la mesa
        return view('pedido.action');

        
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

        return view('pedido.action', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición
        $marca = Pedido::find($id); // Obtenemos la marca por ID
        return view('pedido.action', compact('marca'));

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
