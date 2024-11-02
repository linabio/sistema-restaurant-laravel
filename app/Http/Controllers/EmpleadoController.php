<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\TipoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $registros = Empleado::join('tipos_empleado', 'empleados.id_tipo_empleado', '=', 'tipos_empleado.idTipoEmpleado')
            ->select('empleados.id', 'empleados.id_tipo_empleado', 'empleados.nombre', 'empleados.apellido', 'empleados.imagen', 'empleados.estado', 'tipos_empleado.nombreTipoEmpleado')
            ->where('empleados.nombre', 'LIKE', '%'.$texto.'%')
            ->orWhere('empleados.apellido', 'LIKE', '%'.$texto.'%')
            ->orderBy('empleados.id', 'desc')
            ->paginate(10);

        return view('empleado.index', compact('registros', 'texto'));
    }

    public function create()
    {
        $empleado = new Empleado();
        $tiposEmpleado = TipoEmpleado::select('idTipoEmpleado', 'nombreTipoEmpleado')
            ->orderBy('nombreTipoEmpleado', 'asc')
            ->get();
        return view('empleado.action', compact('empleado', 'tiposEmpleado'));
    }

    public function store(Request $request)
    {
        $registro = new Empleado();
        $registro->id = $request->input('id');
        $registro->id_tipo_empleado = $request->input('id_tipo_empleado');
        $registro->nombre = $request->input('nombre');
        $registro->apellido = $request->input('apellido');
        $registro->estado = $request->input('estado');
        $registro->fecha_registro = now();
        $registro->fecha_edicion = now();

        $prefijo = Str::random(2);
        $image = $request->file('imagen');
        if (!is_null($image)) {
            $nombreImagen = $prefijo.'-'.$image->getClientOriginalName();
            $image->move('empleados', $nombreImagen);
            $registro->imagen = $nombreImagen;
        }

        $registro->save();
        return redirect()->route('empleado.index')->with('mensaje', 'Registro '.$registro->nombre.' creado satisfactoriamente.');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        $tiposEmpleado = TipoEmpleado::select('idTipoEmpleado', 'nombreTipoEmpleado')
            ->orderBy('nombreTipoEmpleado', 'asc')
            ->get();
        return view('empleado.action', compact('empleado', 'tiposEmpleado'));
    }

    public function update(Request $request, $id)
    {
        try {
            $registro = Empleado::findOrFail($id);
            $registro->id_tipo_empleado = $request->input('id_tipo_empleado');
            $registro->nombre = $request->input('nombre');
            $registro->apellido = $request->input('apellido');
            $registro->estado = $request->input('estado');
            $registro->fecha_edicion = now();

            $prefijo = Str::random(2);
            $image = $request->file('imagen');
            if (!is_null($image)) {
                $imagenAntigua = 'empleados/'.$registro->imagen;
                if (file_exists($imagenAntigua)) {
                    @unlink($imagenAntigua);
                }

                $nombreImagen = $prefijo.'-'.$image->getClientOriginalName();
                $image->move('empleados', $nombreImagen);
                $registro->imagen = $nombreImagen;
            }

            $registro->save();
            return redirect()->route('empleado.index')->with('mensaje', 'Registro '.$registro->nombre.' actualizado satisfactoriamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('empleado.index')->with('error', 'No se puede actualizar el registro');
        }
    }

    public function destroy($id)
    {
        try {
            $registro = Empleado::findOrFail($id);
            $imagenAntigua = 'empleados/'.$registro->imagen;
            if (file_exists($imagenAntigua)) {
                @unlink($imagenAntigua);
            }

            $registro->delete();
            return redirect()->route('empleado.index')->with('mensaje', 'Registro '.$registro->nombre.' eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('empleado.index')->with('error', 'No se puede eliminar el registro '.$registro->nombre.' porque está siendo usado.');
        }
    }
}