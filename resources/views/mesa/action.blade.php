<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Marca</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{$marca->id ? route('marca.update',$marca) : route('marca.store')}}" method="post">
            @if($marca->id)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $marca->id }}">
            @endif
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{$marca->nombre}}" required placeholder="Ingrese nombre">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
</div>