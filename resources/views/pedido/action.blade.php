<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">{{ isset($pedido->id) ? 'Editar' : 'Crear' }} Pedido</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{ isset($pedido->id) ? route('pedido.update', $pedido->id) : route('pedido.store') }}" method="POST">
        @csrf
        @if(isset($pedido->id))
            @method('PUT')
        @endif
        <div class="modal-body">
            <div class="form-group">
                <label for="idCliente">ID Cliente</label>
                <input type="text" class="form-control" id="idCliente" name="idCliente" value="{{ old('idCliente', $pedido->idCliente ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="idEmpleado">ID Empleado</label>
                <input type="text" class="form-control" id="idEmpleado" name="idEmpleado" value="{{ old('idEmpleado', $pedido->idEmpleado ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="total">Total</label>
                <input type="number" step="0.01" class="form-control" id="total" name="total" value="{{ old('total', $pedido->total ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="1" {{ (old('estado', $pedido->estado ?? '') == 1) ? 'selected' : '' }}>Completado</option>
                    <option value="0" {{ (old('estado', $pedido->estado ?? '') == 0) ? 'selected' : '' }}>Pendiente</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">{{ isset($pedido->id) ? 'Actualizar' : 'Crear' }}</button>
        </div>
    </form>
</div>
