<?php

namespace App\Http\Controllers;

use App\Events\ActualizacionBitacora;
use App\PresentacionProducto;
use App\Producto;
use App\MovimientoProducto;
use App\Marca;
use App\Modelo;
use App\Compania;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $presentaciones = PresentacionProducto::all();
        $marcas = Marca::all();
        $modelos = Modelo::all();
        $companias = Compania::all();

        return view('admin.productos.create', compact('presentaciones', 'marcas', 'companias','modelos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->all();
        $producto = Producto::create($data);
        $producto->user_id = Auth::user()->id;
        $producto->save();

        event(new ActualizacionBitacora($producto->id, Auth::user()->id, 'Creación', '', $producto, 'productos'));

        return redirect()->route('productos.index')->withFlash('El producto se ha registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $existencias = MovimientoProducto::select(
            'productos.id',
            'productos.codigo',
            'productos.descripcion',
            'productos.precio_venta',
            'tiendas.tienda',
            DB::raw('SUM(movimientos_producto.existencias) as existencias')
        )->join(
            'bodegas',
            'movimientos_producto.bodega_id',
            '=',
            'bodegas.id'
        )->join(
            'productos',
            'movimientos_producto.producto_id',
            '=',
            'productos.id'
        )->join(
            'tiendas',
            'bodegas.tienda_id',
            '=',
            'tiendas.id'
        )->where(
            'productos.id',
            '=',
            $id
        )->groupBy(
            'productos.id',
            'productos.codigo',
            'productos.descripcion',
            'productos.precio_venta',
            'tiendas.tienda'
        )->get();


        $existenciasbod = MovimientoProducto::select(
            'productos.id',
            'productos.codigo',
            'productos.descripcion',
            'productos.precio_venta',
            'tiendas.tienda',
            'bodegas.nombre',
            DB::raw('SUM(movimientos_producto.existencias) as existencias')
        )->join(
            'bodegas',
            'movimientos_producto.bodega_id',
            '=',
            'bodegas.id'
        )->join(
            'productos',
            'movimientos_producto.producto_id',
            '=',
            'productos.id'
        )->join(
            'tiendas',
            'bodegas.tienda_id',
            '=',
            'tiendas.id'
        )->where(
            'productos.id',
            '=',
            $id
        )->groupBy(
            'productos.id',
            'productos.codigo',
            'productos.descripcion',
            'productos.precio_venta',
            'tiendas.tienda',
            'bodegas.nombre'
        )->get();

            
        return view('admin.productos.show', compact('existencias','existenciasbod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $presentaciones = PresentacionProducto::all();
        $marcas = Marca::all();
        $modelos = Modelo::all();
        $companias = Compania::all();

        return view('admin.productos.edit', compact('producto', 'presentaciones', 'marcas', 'companias', 'modelos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $this->validate($request,[
            'codigo'=>'required',
            'descripcion'=>'required',
        ]);

        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'marca_id' => $request->marca_id,
            'modelo' => $request->modelo,
            'imei' => $request->imei,
            'compania_id' => $request->compania_id,
            'descripcion' => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'stock_maximo' => $request->stock_maximo,
            'stock_minimo' => $request->stock_minimo
        );

        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($producto->id, Auth::user()->id, 'Edición', $producto, $json, 'productos'));

        $producto->update($request->all());

        return redirect()->route('productos.index', $producto)->withFlash('El producto se ha actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto, Request $request)
    {
        $producto->estado = 2;
        $producto->save();

        event(new ActualizacionBitacora($producto->id, Auth::user()->id, 'Inactivación', '', '', 'productos'));

        return Response::json(['success'=>'Éxito']);
    }


    public function eliminar(Producto $producto, Request $request)
    {
        $producto->delete();

        event(new ActualizacionBitacora($producto->id, Auth::user()->id, 'Eliminación', '', '', 'productos'));

        return Response::json(['success'=>'Éxito']);
    }


    public function activar(Producto $producto, Request $request)
    {
        $producto->estado = 1;
        $producto->save();

        event(new ActualizacionBitacora($producto->id, Auth::user()->id, 'Activación', '', '', 'productos'));

        return Response::json(['success' => 'Éxito']);
    }

    public function getJson(Request $params)
    {
        $api_result['data'] = Producto::select(
            'productos.codigo',
            'productos.descripcion',
            'productos.precio_venta',
            'productos.estado',
            'productos.id',
            'presentaciones_producto.presentacion',
            DB::raw('SUM(movimientos_producto.existencias) as existencias')
        )->join(
            'presentaciones_producto',
            'productos.presentacion',
            '=',
            'presentaciones_producto.id'
        )->leftJoin(
            'movimientos_producto',
            'movimientos_producto.producto_id',
            '=',
            'productos.id'
        )->groupBy(
            'productos.codigo',
            'productos.descripcion',
            'productos.precio_venta',
            'productos.estado',
            'productos.id',
            'presentaciones_producto.presentacion'
        )->get();

        return Response::json($api_result);
    }



    public function getModelos($id){
        
        $api_result = Modelo::Select(
            'modelos.id',
            'modelos.modelo'
        )->Where(
            'modelos.marca_id',
            '=',
            $id
        )->Where(
            'modelos.estado_id',
            '=',
            1
        )->get();  
        
        return Response::json($api_result);
    }

    public function getProductos()
    {
        $descripcion = Input::get('descripcion');
        $query = Producto::where('descripcion', $descripcion)->get();
        $contador = count($query);
        if ($contador == 0) {
            return 'false';
        } else {
            return 'true';
        }
    }


    public function getCodigos()
    {
        $codigo = Input::get('codigo');
        $query = Producto::where('codigo', '=', $codigo)->get();
        $contador = count($query);
        if ($contador == 0) {
            return 'false';
        } else {
            return 'true';
        }
    }


}

