@extends('plantilla.app')

@section('contenido')
<!-- CONTENIDO -->
<!-- TABLA -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">
                            Productos 
                            <button class="btn btn-primary" onclick="nuevo()">
                                <i class="fas fa-file"></i> Nuevo
                            </button> 
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-file-csv"></i> CSV
                            </a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('producto.index') }}" method="GET">
                            <div class="input-group">
                                <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar productos...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </form>

                        @if (session('mensaje'))
                            <div class="alert alert-info alert-dismissible fade show mt-2">
                                <span class="alert-icon"><i class="fa fa-info"></i></span>
                                <span class="alert-text">{{ session('mensaje') }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-2">
                                <span class="alert-icon"><i class="fa fa-exclamation-triangle"></i></span>
                                <span class="alert-text">{{ session('error') }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($registros->isEmpty())
                            <div class="alert alert-secondary mt-2" role="alert">
                                No hay registros para mostrar
                            </div>
                        @endif

                        <div class="mt-2 table-responsive">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Opciones</th>
                                        <th style="width: 20%">Nombre</th>
                                        <th style="width: 15%">Marca</th>
                                        <th style="width: 15%">Tipo</th>
                                        <th style="width: 10%">Precio</th>
                                        <th style="width: 10%">Stock</th>
                                        <th style="width: 10%">Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registros as $reg)
                                        <tr>
                                            <td>
                                                <button class="btn btn-warning btn-sm" onclick="editar({{ $reg->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" data-toggle="modal" data-target="#modal-eliminar-{{ $reg->id }}" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>{{ $reg->nombre }}</td>
                                            <td>{{ $reg->marca->nombre }}</td>
                                            <td>{{ $reg->tipoProducto->nombre }}</td>
                                            <td>{{ number_format($reg->precio_unitario, 2) }}</td>
                                            <td>{{ $reg->stock }}</td>
                                            <td>{{ $reg->descripcion }}</td>
                                        </tr>
                                        @include('producto.delete', ['registro' => $reg]) <!-- Se pasa el registro a la vista de eliminación -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            {{ $registros->appends(['texto' => $texto])->links() }} <!-- Paginación -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN TABLA -->

<!-- MODAL UPDATE -->
<div class="modal fade" id="modal-action" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
    </div>
</div>
<!-- FIN MODAL UPDATE -->

@endsection

@push('scripts')
<script>
    $('#liAlmacen').addClass("menu-open");      
    $('#liProducto').addClass("active");
    $('#aAlmacen').addClass("active");

    function nuevo(){
        $.ajax({
            method: 'get',
            url: `{{ url('producto/create') }}`,
            success: function(res){
                $('#modal-action').find('.modal-dialog').html(res);
                $('#modal-action').modal("show");              
            }
        });
    }

    function editar(id){
        $.ajax({
            method: 'get',
            url: `{{ url('producto') }}/${id}/edit`,
            success: function(res){
                $('#modal-action').find('.modal-dialog').html(res);
                $('#modal-action').modal("show");              
            }
        });
    }
</script>
@endpush
