@extends('plantilla.app')
@section('contenido')

<h1>Crear Nueva Mesa</h1>

<form action="{{ route('mesas.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="numero">Número de Mesa</label>
        <input type="number" name="numero" id="numero" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="capacidad">Capacidad</label>
        <input type="number" name="capacidad" id="capacidad" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="estado">Estado</label>
        <select name="estado" id="estado" class="form-control" required>
            <option value="Disponible">Disponible</option>
            <option value="Ocupada">Ocupada</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Crear Mesa</button>
</form>

@endsection
