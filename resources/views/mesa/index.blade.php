@extends('plantilla.app')
@section('contenido')

    <link rel="stylesheet" href="{{ asset('css/mesas.css') }}">

    <h1>Listado de Mesas <button class="btn btn-primary" type="submit">Buscar</button> </h1>
    <h5 class="m-0">Marcas <button class="btn btn-primary" onclick="nuevo()"><i class="fas fa-file"></i> Nuevo</button> 



    {{-- <h1>Mesas en el Restaurante</h1> --}}

    <div class="flex-container">
        @foreach ($registros as $mesa)
            <div class="table {{ $mesa->is_large ? 'large' : '' }}">
                <span class="table-icon">🪑</span>
                <div class="table-number">Mesa {{ $mesa->numero }}</div>
                <div class="table-status {{ $mesa->is_occupied ? 'occupied' : 'available' }}">{{  $mesa->is_occupied ? 'occupied' : 'available'  }}</div>
            </div>
        @endforeach
    </div>

    <p class="note">Prueba a cambiar el tamaño de la ventana del navegador para ver cómo se adaptan las mesas.</p>



    {{-- Tabla de Mesas --}}
    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Número de Sillas</th>
                <th>Grande</th>
                <th>Ocupada</th>
                <th>Lista de Pedidos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registros as $mesa)
                <tr>
                    <td>{{ $mesa->id }}</td>
                    <td>{{ $mesa->numero }}</td>
                    <td>{{ $mesa->numero_de_sillas }}</td>
                    <td>{{ $mesa->is_large ? 'Sí' : 'No' }}</td>
                    <td>{{ $mesa->is_occupied ? 'Sí' : 'No' }}</td>
                    <td>{{ implode(', ', json_decode($mesa->lista_de_pedidos) ?? []) }}</td>
                    <td>
                        <a href="{{ route('mesas.edit', $mesa->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('mesas.destroy', $mesa->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta mesa?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No se encontraron mesas.</td>
                </tr>
            @endforelse
        </tbody>
    </table> --}}

    {{-- Paginación --}}
    {{-- <div class="d-flex justify-content-center">
        {{ $registros->links() }}
    </div> --}}
@endsection



@push('scripts')
<script>
    $('#liAlmacen').addClass("menu-open");      
    $('#liMarca').addClass("active");
    $('#aAlmacen').addClass("active");

    function nuevo(){
      $.ajax({
            method: 'get',
            url: `{{url('marca/create')}}`,
            success: function(res){
              $('#modal-action').find('.modal-dialog').html(res);
              $("#textoBoton").text("Guardar");
              $('#modal-action').modal("show");              
            }
          });
    }

    function editar(id){
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
</script>
@endpush