@extends('plantilla.app')
@section('contenido')

<link rel="stylesheet" href="{{ asset('css/mesas.css') }}">

<h1>Listado de Mesas
    <button class="btn btn-primary" type="submit">Buscar</button>
    <a href="{{ route('mesa.create') }}" class="btn btn-primary">Crear Nueva Mesa</a>

</h1>

<div class="flex-container">
    @foreach ($registros as $mesa)
    <div
        class="table {{ $mesa->is_large ? 'large' : '' }}"
        onclick="redirigirAPedido({{ $mesa->id }})"
        style="cursor: pointer;">
        <span class="table-icon">🪑</span>
        <div class="table-number">Mesa {{ $mesa->numero }}</div>
        <div class="table-status {{ $mesa->is_occupied ? 'occupied' : 'available' }}">
            {{ $mesa->is_occupied ? 'Ocupada' : 'Disponible' }}
        </div>
    </div>
    @endforeach
</div>

<p class="note">Prueba a cambiar el tamaño de la ventana del navegador para ver cómo se adaptan las mesas.</p>

{{-- Paginación --}}
<div class="d-flex justify-content-center">
    {{ $registros->links() }}
</div>

@endsection

@push('scripts')
<script>
    function nuevoPedido() {
        $.ajax({
            method: 'get',
            url: `{{ url('mesas') }}/${{ $mesa->id }}/pedido/create`,
            success: function(res) {
                $('#modal-pedido').find('.modal-dialog').html(res);
                $('#modal-pedido').modal("show");
            }
        });
    }

    function editarPedido(id) {
        $.ajax({
            method: 'get',
            url: `{{ url('pedido') }}/${id}/edit`,
            success: function(res) {
                $('#modal-pedido').find('.modal-dialog').html(res);
                $('#modal-pedido').modal("show");
            }
        });
    }

    function redirigirAPedido(mesaId) {
        window.location.href = `{{ url('mesa') }}/${mesaId}/pedidos`;
    }
</script>
@endpush