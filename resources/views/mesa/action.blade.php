<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">{{ $mesa->mesa_id ? 'Editar' : 'Crear' }} Mesa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ $mesa->mesa_id ? route('mesa.update', $mesa) : route('mesa.store') }}" method="POST">
            @csrf
            @if($mesa->mesa_id)
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numero">Número de Mesa</label>
                        <input type="number" class="form-control" id="numero" name="numero" value="{{ $mesa->numero }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="capacidad">Capacidad</label>
                        <input type="number" class="form-control" id="capacidad" name="capacidad" value="{{ $mesa->capacidad }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="1" {{ $mesa->estado == 1 ? 'selected' : '' }}>Ocupada</option>
                    <option value="0" {{ $mesa->estado == 0 ? 'selected' : '' }}>Libre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pedido_id">Pedido Asociado</label>
                <select class="form-control" id="pedido_id" name="pedido_id">
                    @foreach($pedidos as $pedido)
                        <option value="{{ $pedido->id }}" {{ $mesa->pedido_id == $pedido->id ? 'selected' : '' }}>
                            {{ $pedido->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ $mesa->mesa_id ? 'Actualizar' : 'Crear' }} Mesa</button>
            </div>
        </form>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
</div>
