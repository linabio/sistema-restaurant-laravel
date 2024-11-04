<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Pedido;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $registros = Mesa::orderBy('numero', 'asc')->paginate(10);
        // return view('mesa.index', compact('registros'));



        $texto = trim($request->get('texto'));
        $registros = Mesa::where('id', 'LIKE', '%'.$texto.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('mesa.index', compact(['registros', 'texto']));
    }

    public function create()
    {
        return view('mesa.create'); // Crea una vista para el formulario de creación de mesa

    }

    public function store(Request $request)
    {


        
        // Validación de los campos del formulario
        $request->validate([
            'numero' => 'required|integer',
            'capacidad' => 'required|integer',
            'estado' => 'required|string'
        ]);



                // Crear un nuevo pedido
                $pedido = Pedido::create([
                    'cliente_id' => 1,
                    'empleado_id' => 1,
                    'estado' => 1, // Usa el nombre correcto según tu formulario
                    'total' => 1,
                ]);
        
                // Crear una nueva mesa asociando el ID del pedido
                Mesa::create([
                    'numero' => $request->numero,
                    'capacidad' => $request->capacidad,
                    'estado' => $request->estado,
                    'pedido_id' => $pedido->id, // Asocia el ID del nuevo pedido
                ]);
        
        // Crear una nueva mesa
        // Mesa::create($request->all());

        // Redireccionar con un mensaje de éxito
        return redirect()->route('mesas.index')->with('success', 'Mesa creada exitosamente');
    }

    

    public function pedidos(Mesa $mesa)
    {

        $pedidos = Pedido::where('id', 'LIKE', '%'.$mesa-> pedido_id.'%')
                ->orderBy('id', 'desc')
                ->paginate(10);
    

        return view('mesa.pedidos', compact('mesa', 'pedidos'));
    }

    // Método para mostrar el formulario de pedido de una mesa específica
    public function createPedido(Mesa $mesa)
    {
        return view('mesas.pedido', compact('mesa'));
    }

    // Método para guardar el pedido en la base de datos
    public function storePedido(Request $request, Mesa $mesa)
    {
        $request->validate([
            'idCliente' => 'required|string|max:8',
            'idEmpleado' => 'required|string|max:8',
            'total' => 'required|numeric|min:0'
        ]);

        // Crear el pedido
        Pedido::create([
            'idPedido' => uniqid(), // Generar un ID único para el pedido
            'idCliente' => $request->idCliente,
            'idEmpleado' => $request->idEmpleado,
            'estado' => 1, // Puedes definir el estado según tus necesidades
            'total' => $request->total,
            'id' => $mesa->id, // Asociar el pedido con la mesa seleccionada
        ]);

        return redirect()->route('mesas.index')->with('success', 'Pedido creado con éxito.');
    }
}
