@extends('plantilla.app')

@section('contenido')
<!--CONTENIDO-->
<!-- TABLA -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">Usuarios <button class="btn btn-primary" id="btnNuevo"><i class="fas fa-file"></i> Nuevo</button>
                        <a href="" class="btn btn-success"><i class="fas fa-file-csv"></i> CSV</a></h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('usuario.index') }}" method="get">
                            <div class="input-group">
                                <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar usuarios...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </form>

                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            <span class="alert-icon"><i class="fa fa-info"></i></span>
                            <span class="alert-text">{{ Session::get('mensaje') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-2">
                            <span class="alert-icon"><i class="fa fa-info"></i></span>
                            <span class="alert-text">{{ Session::get('error') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(count($registros) == 0)
                        <div class="alert alert-secondary mt-2" role="alert">
                            No hay registros para mostrar
                        </div>
                        @endif

                        <div class="mt-2 table-responsive">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 15%">Opciones</th>
                                        <th style="width: 20%">Nombre</th>
                                        <th style="width: 25%">Email</th>
                                        <th style="width: 20%">Tipo de Usuario</th>
                                        <th style="width: 20%">DNI Relacionado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($registros) == 0)
                                    <tr>
                                        <td colspan="5">No hay resultados</td>
                                    </tr>
                                    @else
                                    @foreach($registros as $reg)
                                    <tr>
                                        <td>
                                            <button class="btn btn-warning btn-sm btnEditar" data-id="{{ $reg->id }}"><i class="fas fa-edit"></i></button>
                                            <button type="button" data-toggle="modal" data-target="#modal-eliminar-{{ $reg->id }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </td>
                                        <td>{{ $reg->nombre }}</td>
                                        <td>{{ $reg->email }}</td>
                                        <td>{{ class_basename($reg->userable_type) }}</td>
                                        <td>{{ $reg->userable_id }}</td>
                                    </tr>
                                    @include('usuario.delete')
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            {{ $registros->appends(["texto" => $texto]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- FIN TABLA -->

<!-- MODAL UPDATE -->
<div class="modal fade" id="modal-action" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg"></div>
</div>
<!-- FIN MODAL UPDATE -->
<!-- FIN CONTENIDO -->

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#liUsuarios').addClass("menu-open");
        $('#liUsuario').addClass("active");
        $('#aUsuarios').addClass("active");

        function nuevo() {
            $.ajax({
                method: 'GET',
                url: "{{ route('usuario.create') }}",
                success: function(res) {
                    $('#modal-action').find('.modal-dialog').html(res);
                    $('#modal-action').modal("show");
                },
                error: function(xhr, status, error) {
                    console.error("Error loading create form:", error);
                    alert("Error loading create form. Please try again.");
                }
            });
        }

        function editar(id) {
            $.ajax({
                method: 'GET',
                url: "{{ url('usuario') }}/" + id + "/edit",
                success: function(res) {
                    $('#modal-action').find('.modal-dialog').html(res);
                    $('#modal-action').modal("show");
                },
                error: function(xhr, status, error) {
                    console.error("Error loading edit form:", error);
                    alert("Error loading edit form. Please try again.");
                }
            });
        }

        $('#btnNuevo').on('click', function(e) {
            e.preventDefault();
            nuevo();
        });

        $(document).on('click', '.btnEditar', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            editar(id);
        });
    });
</script>
@endpush
