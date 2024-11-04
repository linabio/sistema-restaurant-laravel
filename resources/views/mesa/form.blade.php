<form action="{{ isset($mesa) && $mesa->mesa_id ? route('mesa.update', $mesa) : route('mesa.store') }}" method="POST">
    @csrf
    @if(isset($mesa) && $mesa->mesa_id)
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="numero">Número de Mesa</label>
        <input type="number" class="form-control" id="numero" name="numero" value="{{ $mesa->numero ?? old('numero') }}" required>
    </div>

    <div class="form-group">
        <label for="capacidad">Capacidad</label>
        <input type="number" class="form-control" id="capacidad" name="capacidad" value="{{ $mesa->capacidad ?? old('capacidad') }}" required>
    </div>

    <div class="form-group">
        <label for="estado">Estado</label>
        <select class="form-control" id="estado" name="estado" required>
            <option value="1" {{ (isset($mesa) && $mesa->estado == 1) ? 'selected' : '' }}>Ocupada</option>
            <option value="0" {{ (isset($mesa) && $mesa->estado == 0) ? 'selected' : '' }}>Libre</option>
        </select>
    </div>

    <div class="form-group">
        <label for="pedido_id">Pedido Asociado</label>
        <select class="form-control" id="pedido_id" name="pedido_id">
            <option value="">Ninguno</option>
            @foreach($pedidos as $pedido)
                <option value="{{ $pedido->id }}" {{ (isset($mesa) && $mesa->pedido_id == $pedido->id) ? 'selected' : '' }}>
                    {{ $pedido->descripcion }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($mesa) && $mesa->mesa_id ? 'Actualizar' : 'Crear' }} Mesa</button>
</form>
