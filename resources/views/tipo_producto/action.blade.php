<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">{{ isset($tipoProducto->id) ? 'Editar Tipo de Producto' : 'Crear Tipo de Producto' }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{ isset($tipoProducto->id) ? route('tipo_producto.update', $tipoProducto->id) : route('tipo_producto.store') }}" method="post">
        @csrf
        @if(isset($tipoProducto->id))
            @method('PUT')
        @endif
        <div class="modal-body">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingrese el nombre" value="{{ $tipoProducto->nombre ?? '' }}" required>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="textoBoton">{{ isset($tipoProducto->id) ? 'Actualizar' : 'Guardar' }}</button>
        </div>
    </form>
</div>