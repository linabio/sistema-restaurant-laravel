<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;

class DetallePedidoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($pedidoId)
    {
        $pedido = Pedido::findOrFail($pedidoId);
        $productos = Producto::select('id', 'nombre', 'precio_unitario')->orderBy('nombre', 'asc')->get();

        return view('detalle_pedido.create', compact('pedido', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $pedidoId)
    {
        $validatedData = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $detalle = new DetallePedido($validatedData);
        $detalle->pedido_id = $pedidoId;
        $detalle->save();

        return redirect()->route('pedido.show', $pedidoId)->with('mensaje', 'Detalle agregado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $detalle = DetallePedido::findOrFail($id);
        $productos = Producto::select('id', 'nombre', 'precio_unitario')->orderBy('nombre', 'asc')->get();

        return view('detalle_pedido.edit', compact('detalle', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $detalle = DetallePedido::findOrFail($id);

        $validatedData = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $detalle->update($validatedData);

        return redirect()->route('pedido.show', $detalle->pedido_id)->with('mensaje', 'Detalle actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detalle = DetallePedido::findOrFail($id);
        $pedidoId = $detalle->pedido_id;
        $detalle->delete();

        return redirect()->route('pedido.show', $pedidoId)->with('mensaje', 'Detalle eliminado correctamente.');
    }
}