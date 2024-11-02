<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $registros = Usuario::where('nombre', 'LIKE', '%'.$texto.'%')
            ->orWhere('email', 'LIKE', '%'.$texto.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('usuario.index', compact(['registros', 'texto']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = new Usuario();
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        return view('usuario.action', compact('usuario', 'clientes', 'empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'nombre' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:usuarios,email',
            'tipo_usuario' => 'required|string|in:cliente,empleado',
            'id_relacionado' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->tipo_usuario === 'cliente') {
                        if (!Cliente::where('id', $value)->exists()) {
                            $fail('El cliente seleccionado no existe.');
                        }
                    } elseif ($request->tipo_usuario === 'empleado') {
                        if (!Empleado::where('id', $value)->exists()) {
                            $fail('El empleado seleccionado no existe.');
                        }
                    }
                },
            ],
            'password' => 'required|string|min:8',  // Validación para la contraseña
        ]);

        $registro = new Usuario();
        $registro->nombre = $request->input('nombre');
        $registro->email = $request->input('email');
        $registro->password = $request->input('password'); // Asigna la contraseña

        // Asociar el usuario con un cliente o empleado
        if ($request->input('tipo_usuario') === 'cliente') {
            $cliente = Cliente::findOrFail($request->input('id_relacionado'));
            $registro->userable()->associate($cliente);
        } elseif ($request->input('tipo_usuario') === 'empleado') {
            $empleado = Empleado::findOrFail($request->input('id_relacionado'));
            $registro->userable()->associate($empleado);
        }

        $registro->save();
        return redirect()->route('usuario.index')->with('mensaje', 'Registro '.$registro->nombre.' creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        // Aquí puedes agregar la lógica para mostrar un usuario específico
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        return view('usuario.action', compact(['usuario', 'clientes', 'empleados']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $usuario = Usuario::findOrFail($id);

    // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:usuarios,email,' . $id,
        'tipo_usuario' => 'required',
        'id_relacionado' => 'required|string|max:20',
        'password' => 'nullable|string|min:8|confirmed', // Validación de contraseña
    ]);

    $usuario->nombre = $request->nombre;
    $usuario->email = $request->email;
    $usuario->userable_id = $request->id_relacionado;
    
    // Si se proporciona una nueva contraseña, la actualizamos
    if ($request->filled('password')) {
        $usuario->password = Hash::make($request->password);
    }

    $usuario->save();

    return redirect()->route('usuario.index')->with('mensaje', 'Usuario actualizado correctamente.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $registro = Usuario::findOrFail($id);
            $registro->delete();
            return redirect()->route('usuario.index')->with('mensaje', 'Registro '.$registro->nombre.' eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('usuario.index')->with('error', 'No se puede eliminar el registro '.$registro->nombre.' porque está siendo usado.');
        }
    }
}
