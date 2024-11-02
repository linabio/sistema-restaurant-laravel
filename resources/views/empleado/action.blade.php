<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">{{ $empleado->id ? 'Editar' : 'Crear' }} Empleado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ $empleado->id ? route('empleado.update', $empleado) : route('empleado.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($empleado->id)
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id">DNI</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $empleado->id }}" {{ $empleado->id ? 'readonly' : '' }} required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_tipo_empleado">Tipo de Empleado</label>
                        <select class="form-control" id="id_tipo_empleado" name="id_tipo_empleado" required>
                            @foreach($tiposEmpleado as $tipo)
                                <option value="{{ $tipo->idTipoEmpleado }}" {{ $empleado->id_tipo_empleado == $tipo->idTipoEmpleado ? 'selected' : '' }}>
                                    {{ $tipo->nombreTipoEmpleado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $empleado->nombre }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $empleado->apellido }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                @if($empleado->imagen)
                    <div class="mt-2">
                        <img src="{{ asset('empleados/' . $empleado->imagen) }}" alt="Imagen actual" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="1" {{ $empleado->estado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $empleado->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ $empleado->id ? 'Actualizar' : 'Crear' }} Empleado</button>
            </div>
        </form>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
</div>