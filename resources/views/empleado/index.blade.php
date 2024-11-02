@extends('plantilla.app')
@section('contenido')
<!--CONTENIDO-->
<!-- TABLA -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">Empleados <button class="btn btn-primary" id="btnNuevo"><i class="fas fa-file"></i> Nuevo</button> 
                        <a href="" class="btn btn-success"><i class="fas fa-file-csv"></i> CSV</a></h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('empleado.index')}}" method="get">
                            <div class="input-group">
                                <input name="texto" type="text" class="form-control" value="{{$texto}}" placeholder="Buscar empleados...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </form>
                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            <span class="alert-icon"><i class="fa fa-info"></i></span>
                            <span class="alert-text">{{Session::get('mensaje')}}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-2">
                            <span class="alert-icon"><i class="fa fa-info"></i></span>
                            <span class="alert-text">{{Session::get('error')}}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(count($registros)==0)
                        <div class="alert alert-secondary mt-2" role="alert">
                            No hay registros para mostrar
                        </div>
                        @endif
                        <div class="mt-2 table-responsive">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 15%">Opciones</th>
                                        <th style="width: 10%">DNI</th>
                                        <th style="width: 20%">Nombre</th>
                                        <th style="width: 20%">Apellido</th>
                                        <th style="width: 15%">Tipo</th>
                                        <th style="width: 10%">Estado</th>
                                        <th style="width: 10%">Imagen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($registros)==0)
                                    <tr>
                                        <td colspan="7">No hay resultados</td>
                                    </tr>
                                    @else
                                    @foreach($registros as $reg)
                                    <tr>
                                        <td>
                                            <button class="btn btn-warning btn-sm btnEditar" data-id="{{$reg->id}}"><i class="fas fa-edit"></i></button>
                                            <button type="button" data-toggle="modal" data-target="#modal-eliminar-{{$reg->id}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </td>
                                        
                                        <td>{{$reg->id}}</td>
                                        <td>{{$reg->nombre}}</td>
                                        <td>{{$reg->apellido}}</td>
                                        <td>{{$reg->nombreTipoEmpleado}}</td>
                                        <td>
                                            @if($reg->estado == 1)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reg->imagen)
                                                <img src="{{ asset('empleados/' . $reg->imagen) }}" alt="Imagen de {{$reg->nombre}}" class="img-thumbnail" style="max-width: 50px;">
                                            @else
                                                <span class="text-muted">Sin imagen</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @include('empleado.delete')
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>                            
                        </div>
                        <div class="table-responsive">
                        {{$registros->appends(["texto" => $texto])}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- FIN TABLA -->
<!--MODAL UPDATE-->
<div class="modal fade" id="modal-action" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
    </div>
</div>
<!--FIN MODAL UPDATE-->

<!--FIN CONTENIDO-->
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#liEmpleados').addClass("menu-open");      
        $('#liEmpleado').addClass("active");
        $('#aEmpleados').addClass("active");

        function nuevo() {
        $.ajax({
            method: 'GET',
            url: "{{ route('empleado.create') }}",
            success: function(res) {
                $('#modal-action').find('.modal-dialog').html(res);
                $('#modal-action').modal("show");
            },
            error: function(xhr, status, error) {
                console.error("Error loading create form:", error); // Muestra el mensaje de error
                console.error("Status:", status); // Muestra el estado del error (ej: 404, 500, etc.)
                console.error("Response:", xhr.responseText); // Muestra el contenido de la respuesta completa
                alert("Error loading create form. Please try again.");
            }
        });
    }

    function editar(id) {
        $.ajax({
            method: 'GET',
            url: "{{ url('empleado') }}/" + id + "/edit",
            success: function(res) {
                $('#modal-action').find('.modal-dialog').html(res);
                $('#modal-action').modal("show");
            },
            error: function(xhr, status, error) {
                console.error("Error loading edit form:", error); // Muestra el mensaje de error
                console.error("Status:", status); // Muestra el estado del error (ej: 404, 500, etc.)
                console.error("Response:", xhr.responseText); // Muestra el contenido de la respuesta completa
                alert("Error loading edit form. Please try again.");
            }
        });
    }

        // Attach click event to the "Nuevo" button
        $('#btnNuevo').on('click', function(e) {
            e.preventDefault();
            nuevo();
        });

        // Attach click event to the edit buttons
        $('.btnEditar').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            editar(id);
        });
    });

</script>
@endpush