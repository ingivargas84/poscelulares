<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\Events\ActualizacionBitacora;
use App\MovimientoProducto;
use App\Producto;
use App\Producto_Imei;
use App\TraspasoBodega;
use App\TraspasoDetalle;
use App\Usuario_Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TraspasosBodegaController extends Controller
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
        return view('admin/traspasos_bodega/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $query = "SELECT roles.id as id
        FROM users
        INNER JOIN model_has_roles ON users.id = model_id
        INNER JOIN roles ON roles.id = model_has_roles.role_id
        WHERE users.id = $user->id";

        $rol= DB::select($query);

        if ($rol[0]->id < 3) {

            $bodegas_origen = Bodega::Where('estado', '=', '1')->get();
            $bodegas_destino = Bodega::Where('estado', '=', '1')->get();
        } elseif ($rol[0]->id == 3) {
            $user_tienda = Usuario_Tienda::Where("user_id","=",Auth::user()->id)->get()->first();
            $bodegas_origen = Bodega::Where("tienda_id","=",$user_tienda->tienda_id)->get();
            $bodegas_destino = Bodega::Where('estado', '=', '1')->Where('id', '>', 1)->get();
        } elseif ($rol[0]->id > 3) {
            $user_tienda = Usuario_Tienda::Where("user_id","=",Auth::user()->id)->get()->first();
            $bodegas_origen = Bodega::Where("tienda_id","=",$user_tienda->tienda_id)->get();
            $bodegas_destino = Bodega::Where('estado', '=', '1')->Where('tienda_id', '!=', $user_tienda->tienda_id)->get();
        }

        $productos = Producto::where('estado', 1)->get();
        return view('admin/traspasos_bodega/create', compact('bodegas_origen', 'bodegas_destino', 'productos'));
    }



    public function getProductoData($id, $bodega)
    {

        $api_result = Producto::select(
            'productos.id',
            'productos.descripcion',
            'productos.precio_venta',
            'productos.presentacion as grupo',
            DB::raw('SUM(movimientos_producto.existencias) as existencias')
        )->join(
            'movimientos_producto',
            'movimientos_producto.producto_id',
            '=',
            'productos.id'
        )->where([
            ['productos.id','=',$id],
            ['movimientos_producto.bodega_id', '=', $bodega]
        ])->groupBy(
            'productos.id',
            'productos.descripcion',
            'productos.precio_venta',
            'productos.presentacion'
        )->get();

        return Response::json($api_result);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


         //make an array from the request data
         $arr = json_decode($request->getContent(), true);
          
         //variables from request
         $user_id                 = Auth::user()->id;
         $bodega_origen           = $arr[1]["value"];
         $bodega_destino          = $arr[2]["value"];


        $tp = TraspasoBodega::create([
            'bodega_origen'  => $bodega_origen,
            'bodega_destino' => $bodega_destino,
            'user_id'        => $user_id,
        ]);

        
        if ($arr[7]["name"] == "stock"){
            $num = 8;
        }
        else
        {
            $num = 10;
        }



        for ($i = $num; $i < sizeof($arr); $i++) {

            $td = TraspasoDetalle::create([
                'cantidad'              => $arr[$i]["cantidad"],
                'imei'                  => $arr[$i]["imei"],
                'producto_id'           => $arr[$i]["producto_id"],
                'traspasos_bodega_id'   => $tp->id
            ]);

            $producto_id = $arr[$i]["producto_id"];
            $cantidad = $arr[$i]["cantidad"];

            $pro = Producto::Where("id","=",$producto_id)->get();

            if ($pro[0]->presentacion <= 2)
            {
                $pi = Producto_Imei::WHERE("imei","=",$arr[$i]["imei"] )->get();
                $pi[0]->bodega_id = $bodega_destino;
                $pi[0]->save();
            }

            event(new ActualizacionBitacora($tp->id, Auth::user()->id, 'Creacion', '', $tp, 'traspasos_bodega'));

            $movimientos = MovimientoProducto::select()->where([
                ['producto_id', $producto_id],
                ['bodega_id',   $bodega_origen]
            ])->orderBy(
                'caducidad'
            )->get();

            $comp = 0;//this variable is to be compared to the transfer ammount.



            if ( $cantidad <= $movimientos->first()->existencias ) {
                $movimientos->first()->decrement('existencias', $cantidad);
                $mp = MovimientoProducto::create([
                'existencias'   => $cantidad,
                'caducidad'     => $movimientos->first()->caducidad,
                'bodega_id'     => $bodega_destino,
                'precio_compra' => $movimientos->first()->precio_compra,
                'producto_id'   => $producto_id
                ]);
                event(new ActualizacionBitacora($mp->id, Auth::user()->id, 'Creacion', '', $mp, 'movimientos_producto'));
        } else {
            foreach ($movimientos as $mov) {
                while ($mov->existencias != 0 && $comp < $cantidad) {
                    $mov->decrement('existencias');
                    $comp ++;
               } ;
            }
            $mp = MovimientoProducto::create([
                'existencias'   => $cantidad,
                'caducidad'     => $movimientos->first()->caducidad,
                'bodega_id'     => $bodega_destino,
                'precio_compra' => $movimientos->first()->precio_compra,
                'producto_id'   => $producto_id
            ]);
            event(new ActualizacionBitacora($mp->id, Auth::user()->id, 'Creacion', '', $mp, 'movimientos_producto'));
        }
    }

        return Response::json(['success' => 'éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tm = $api_result['data'] = TraspasoBodega::select(
            'traspasos_bodega.id',
            'traspasos_bodega.created_at',
            'b1.nombre as bodega_origen',
            'b2.nombre as bodega_destino',
            'users.name as user'
        )->join(
            'bodegas as b1',
            'b1.id',
            '=',
            'traspasos_bodega.bodega_origen'
        )->join(
            'bodegas as b2',
            'b2.id',
            '=',
            'traspasos_bodega.bodega_destino'
        )->join(
            'users',
            'users.id',
            '=',
            'traspasos_bodega.user_id'
        )->where(
            'traspasos_bodega.id',
            '=',
            $id
        )->get();


        $td = $api_result['data'] = TraspasoDetalle::select(
            'traspasos_detalle.id',
            'traspasos_detalle.cantidad',
            'traspasos_detalle.imei',
            'productos.descripcion as producto'
        )->join(
            'productos',
            'traspasos_detalle.producto_id',
            '=',
            'productos.id'
        )->where(
            'traspasos_detalle.traspasos_bodega_id',
            '=',
            $id
        )->get();

        return view('admin.traspasos_bodega.show', compact('tm', 'td'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getJson(){


        $user = Auth::user();
        $query = "SELECT roles.id as id
        FROM users
        INNER JOIN model_has_roles ON users.id = model_id
        INNER JOIN roles ON roles.id = model_has_roles.role_id
        WHERE users.id = $user->id";

        $rol= DB::select($query);

        if ($rol[0]->id < 3){

        $apiResult['data'] = TraspasoBodega::select(
            'traspasos_bodega.id',
            'traspasos_bodega.created_at',
            'b1.nombre as bodega_origen',
            'b2.nombre as bodega_destino',
            'users.name as user'
        )->join(
            'bodegas as b1',
            'b1.id',
            '=',
            'traspasos_bodega.bodega_origen'
        )->join(
            'bodegas as b2',
            'b2.id',
            '=',
            'traspasos_bodega.bodega_destino'
        )->join(
            'users',
            'users.id',
            '=',
            'traspasos_bodega.user_id'
        )->get();

        }else{

            $apiResult['data'] = TraspasoBodega::select(
                'traspasos_bodega.id',
                'traspasos_bodega.created_at',
                'b1.nombre as bodega_origen',
                'b2.nombre as bodega_destino',
                'users.name as user'
            )->join(
                'bodegas as b1',
                'b1.id',
                '=',
                'traspasos_bodega.bodega_origen'
            )->join(
                'bodegas as b2',
                'b2.id',
                '=',
                'traspasos_bodega.bodega_destino'
            )->join(
                'users',
                'users.id',
                '=',
                'traspasos_bodega.user_id'
            )->where(
                'traspasos_bodega.user_id',
                '=',
                Auth::user()->id
            )->get();

        }

        return Response::json($apiResult);
    }



    public function getProduct(Request $params, $id, Bodega $bodega){
        $apiResult = Producto::select(
            'productos.id',
            'productos.nombre_comercial',
            DB::raw('SUM(movimientos_producto.existencias) as existencias')
        )->join(
            'movimientos_producto',
            'movimientos_producto.producto_id',
            '=',
            'productos.id'
        )->where(
            'movimientos_producto.bodega_id',
            $bodega->id
        )->where(
            'productos.codigo',
            $id
        )->groupBy(
            'productos.id',
            'productos.nombre_comercial'
        )->get();

        return Response::json($apiResult);
    }



    public function getProductName(Request $params, $id, Bodega $bodega){
        $apiResult = Producto::select(
            'productos.id',
            'productos.nombre_comercial',
            'productos.presentacion as grupo',
            DB::raw('SUM(movimientos_producto.existencias) as existencias')
        )->join(
            'movimientos_producto',
            'movimientos_producto.producto_id',
            '=',
            'productos.id'
        )->where(
            'movimientos_producto.bodega_id',
            $bodega->id
        )->where(
            'productos.nombre_comercial',
            $id
        )->where(
          'productos.estado',
          '=',
          '1'
          )->groupBy(
            'productos.id',
            'productos.nombre_comercial'
        )->get();

        return Response::json($apiResult);
    }
}
