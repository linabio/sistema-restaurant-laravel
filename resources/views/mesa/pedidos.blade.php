@extends('plantilla.app')

@section('contenido')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pedidos de Mesa {{ $mesa->numero }}</h3>
                <button class="btn btn-primary float-right" onclick="nuevoPedido({{ $mesa->id }})">
                    <i class="fas fa-plus"></i> Nuevo Pedido
                </button>
            </div>
            <div class="card-body">
                @if($pedidos->isEmpty())
                    <div class="alert alert-info">No hay pedidos para esta mesa</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Empleado</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>{{ $pedido->cliente->nombre }}</td>
                                    <td>{{ $pedido->empleado->nombre }}</td>
                                    <td>{{ number_format($pedido->total, 2) }}</td>
                                    <td>{{ $pedido->estado ? 'Completado' : 'Pendiente' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="verPedido({{ $pedido->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editarPedido({{ $pedido->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $pedidos->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

    $('#liAlmacen').addClass("menu-open");      
    $('#liMarca').addClass("active");
    $('#aAlmacen').addClass("active");


    function nuevoPedido(mesaId) {
        // window.location.href = `{{ url('pedidos/create') }}?id=${mesaId}`;

        $.ajax({
                method: 'get',
                url: `{{url('marca')}}/${id}/edit`,
                success: function(res){
                $('#modal-action').find('.modal-dialog').html(res);
                $("#textoBoton").text("Editar");
                $('#modal-action').modal("show");              
                }
            });
        
    }

    function editarPedido(id) {
        window.location.href = `{{ url('pedidos') }}/${id}/edit`;
    }

    function verPedido(id) {
        window.location.href = `{{ url('pedidos') }}/${id}`;
    }

</script>
@endpush
@endsection