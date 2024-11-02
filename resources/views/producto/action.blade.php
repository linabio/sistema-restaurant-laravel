<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">{{ isset($producto->id) ? 'Editar' : 'Crear' }} Producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{ isset($producto->id) ? route('producto.update', $producto->id) : route('producto.store') }}" method="POST">
        @csrf
        @if(isset($producto->id))
            @method('PUT')
        @endif
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="marca_id">Marca</label>
                        <select class="form-control" id="marca_id" name="marca_id" required>
                            @foreach($marcas as $marca)
                                <option value="{{ $marca->id }}" {{ old('marca_id', $producto->marca_id) == $marca->id ? 'selected' : '' }}>{{ $marca->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_producto_id">Tipo de Producto</label>
                        <select class="form-control" id="tipo_producto_id" name="tipo_producto_id" required>
                            @foreach($tiposProducto as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_producto_id', $producto->tipo_producto_id) == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="precio_unitario">Precio Unitario</label>
                        <input type="number" step="0.01" class="form-control" id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario', $producto->precio_unitario) }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">{{ isset($producto->id) ? 'Actualizar' : 'Crear' }}</button>
        </div>
    </form>
</div>