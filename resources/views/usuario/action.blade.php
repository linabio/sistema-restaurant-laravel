<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">{{ isset($usuario) && $usuario->id ? 'Editar Usuario' : 'Crear Usuario' }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="usuarioForm" action="{{ isset($usuario) && $usuario->id ? route('usuario.update', $usuario->id) : route('usuario.store') }}" method="POST">
        @csrf
        @if(isset($usuario) && $usuario->id)
            @method('PUT')
        @endif
        <div class="modal-body">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre ?? '') }}" required>
                @error('nombre')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email ?? '') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="tipo_usuario">Tipo de Usuario</label>
                <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="cliente" {{ (isset($usuario) && $usuario->userable_type == 'App\Models\Cliente') ? 'selected' : '' }}>Cliente</option>
                    <option value="empleado" {{ (isset($usuario) && $usuario->userable_type == 'App\Models\Empleado') ? 'selected' : '' }}>Empleado</option>
                </select>
                @error('tipo_usuario')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="id_relacionado">DNI Relacionado</label>
                <input type="text" class="form-control" id="id_relacionado" name="id_relacionado" value="{{ old('id_relacionado', $usuario->userable_id ?? '') }}" required>
                @error('id_relacionado')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Campos de contraseña -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" {{ isset($usuario) ? '' : 'required' }}>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($usuario) ? '' : 'required' }}>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">{{ isset($usuario) && $usuario->id ? 'Actualizar' : 'Crear' }}</button>
        </div>
    </form>
</div>
