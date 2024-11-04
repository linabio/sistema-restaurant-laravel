@extends('plantilla.app')

@section('contenido')
<!-- CONTENIDO -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="m-0">
                            @if(isset($mesa))
                            Pedidos para Mesa {{ $mesa->numero }}
                            @else
                            Listado de Pedidos
                            @endif

                            <button class="btn btn-primary" onclick="nuevoPedido()">
                                <i class="fas fa-file"></i> Nuevo Pedido
                            </button>
                            
                        </h5>
                    </div>

                    <div class="card-body">
                        <!-- Mensajes de Éxito o Error -->
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

                        <!-- Tabla de Pedidos -->
                        @if ($pedidos->isEmpty())
                        <div class="alert alert-secondary mt-2" role="alert">
                            No hay pedidos para esta mesa
                        </div>
                        @else
                        <div class="table-responsive mt-2">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Opciones</th>
                                        <th>ID Pedido</th>
                                        <th>ID Cliente</th>
                                        <th>ID Empleado</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editarPedido({{ $pedido->id }})">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                            <button type="button" data-toggle="modal" data-target="#modal-eliminar-{{ $pedido->id }}" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                        <td>{{ $pedido->idPedido }}</td>
                                        <td>{{ $pedido->idCliente }}</td>
                                        <td>{{ $pedido->idEmpleado }}</td>
                                        <td>{{ number_format($pedido->total, 2) }}</td>
                                        <td>{{ $pedido->estado ? 'Completado' : 'Pendiente' }}</td>
                                    </tr>
                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            {{ $pedidos->links() }} <!-- Paginación -->
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN CONTENIDO -->

<!-- MODAL para Crear/Editar Pedido -->
<div class="modal fade" id="modal-pedido" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
    </div>
</div>
<!-- FIN MODAL -->

@endsection

@push('scripts')
<script>
    function nuevoPedido() {
        $.ajax({
            method: 'get',
            // url: `{{ url('pedido') }}/${mesa.id}/create`,
            url: `{{ route('pedido.create') }}`, // Utilizamos la ruta definida en web.php

            success: function(res) {
                $('#modal-pedido').find('.modal-dialog').html(res);
                $('#modal-pedido').modal("show");
            }
        });
    }

    function editarPedido(id) {
        $.ajax({
            method: 'get',
            url: `{{ url('pedido') }}/${id}/edit`, // Construimos la URL con el ID

            success: function(res) {
                $('#modal-pedido').find('.modal-dialog').html(res);
                $('#modal-pedido').modal("show");
            }
        });
    }
</script>
@endpush