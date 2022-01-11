<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\SaldoRecargas;
use App\PedidoMaestro;
use App\PedidoDetalle;
use App\VentaCliente;
use App\Tienda;
use App\Bodega;
use App\Compania;
use App\IngresoMaestro;
use App\IngresoDetalle;
use App\TraspasoBodega;
use App\TraspasoDetalle;
use App\MovimientoProducto;
use App\Events\ActualizacionBitacora;
use App\Usuario_Tienda;
use Validator;

class SaldoRecargasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
       $this->middleware('auth');
    }


    public function index()
    {
        return view ("admin.recargas.index");
    }


   public function getJson(Request $params)
     {

        $user = Auth::user();
        $query = "SELECT roles.id as id
        FROM users
        INNER JOIN model_has_roles ON users.id = model_id
        INNER JOIN roles ON roles.id = model_has_roles.role_id
        WHERE users.id = $user->id";

        $rol= DB::select($query);

        if ($rol[0]->id < 3)
        {
            $api_Result['data'] = SaldoRecargas::select(
                'saldo_recargas.id',
                'saldo_recargas.entrada', 
                'saldo_recargas.salida', 
                'saldo_recargas.saldo', 
                'tiendas.tienda', 
                'companias.compania',
                'users.name',
                'saldo_recargas.created_at'
            )->join(
                'tiendas', 
                'saldo_recargas.tienda_id', 
                '=', 
                'tiendas.id'
            )->join(
                'companias', 
                'saldo_recargas.compania_id', 
                '=', 
                'companias.id'
            )->join(
                'users', 
                'saldo_recargas.user_id', 
                '=', 
                'users.id'
            )->where(
                'saldo_recargas.id', 
                '>', 
                8
            )->get();

        }
        else
        {
            $api_Result['data'] = SaldoRecargas::select(
                'saldo_recargas.id',
                'saldo_recargas.entrada', 
                'saldo_recargas.salida', 
                'saldo_recargas.saldo', 
                'tiendas.tienda', 
                'companias.compania',
                'users.name',
                'saldo_recargas.created_at'
            )->join(
                'tiendas', 
                'saldo_recargas.tienda_id', 
                '=', 
                'tiendas.id'
            )->join(
                'companias', 
                'saldo_recargas.compania_id', 
                '=', 
                'companias.id'
            )->join(
                'users', 
                'saldo_recargas.user_id', 
                '=', 
                'users.id'
            )->where(
                'saldo_recargas.id', 
                '>', 
                8
            )->where(
                'saldo_recargas.user_id',
                '=',
                Auth::user()->id
            )->get();

        }      

         return Response::json( $api_Result );
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

        if ($rol[0]->id < 3){
            $tiendas = Tienda::where('estado_id', '=', 1)->get();
        }
        else
        {
            $tt = Usuario_Tienda::where("user_id","=",$user->id)->get();
            $tiendas = Tienda::where("id",$tt[0]->tienda_id)->get();

        }

        $companias = Compania::where('id', '<=', 2)->get();

        return view('admin.recargas.create', compact('companias','tiendas'));
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

        $saldos = SaldoRecargas::Where('tienda_id','=',$request->tienda_id)->Where('compania_id','=',$request->compania_id)->OrderBy('id','DESC')->get()->first();

        $recargas = SaldoRecargas::create($data);
        $recargas->producto_id = 0;
        $recargas->user_id = Auth::user()->id;
        $recargas->salida = 0;
        $recargas->saldo = $saldos->saldo + $request->entrada;
        $recargas->save();

        if($request->tienda_id == 1)
        {
            $bodega = 2;
        }
        elseif($request->tienda_id == 2)
        {
            $bodega = 3;
        }
        elseif($request->tienda_id == 3)
        {
            $bodega = 4;
        }
        elseif($request->tienda_id == 4)
        {
            $bodega = 5;
        }

        if ($request->compania_id == 2){
            $total_ingreso = $request->entrada - ($request->entrada*0.06);
            $proveedor = 6;
            $producto = 354;
        }
        else
        {
            $total_ingreso = $request->entrada;
            $proveedor = 3;
            $producto = 353;
        }

        
        $im = IngresoMaestro::create([
            'user_id'       => Auth::user()->id,
            'proveedor_id'  => $proveedor,
            'serie_factura' => "A",
            'bodega_id'     => 1,
            'fecha_compra'  => Carbon::now(),
            'num_factura'   => 1,
            'fecha_factura' => Carbon::now(),
            'total_ingreso' => $total_ingreso
        ]);

        $mp = MovimientoProducto::create([
                'bodega_id'     => 1,
                'existencias'   => 1,
                'caducidad'     => "2030/01/01",
                'precio_compra' => $total_ingreso,
                'producto_id'   => $producto
        ]);

        $id = IngresoDetalle::create([
                'precio_compra'          => 0,
                'cantidad'               => 1,
                'producto_id'            => $producto,
                'subtotal'               => $total_ingreso,
                'ingreso_maestro_id'     => $im->id,
                "movimiento_producto_id" => $mp->id
        ]);

        $tb = TraspasoBodega::create([
            'cantidad'          => 0,
            'bodega_origen'     => 1,
            'bodega_destino'    => $bodega,
            'producto_id'       => $producto,
            'user_id'           => Auth::user()->id
        ]);

        $td = TraspasoDetalle::create([
            'cantidad'              => 1,
            'producto_id'           => $producto,
            'imei'                  => "",
            'traspasos_bodega_id'   => $tb->id
        ]);
        

         event(new ActualizacionBitacora($recargas->id, Auth::user()->id,'Creación','', $recargas,'Recargas'));
         
         return redirect()->route('recargas.index')->withFlash('El saldo ha sido acreditado exitosamente!');
    }

    


    public function createm()
    {
        $user = Auth::user();
        $query = "SELECT roles.id as id
        FROM users
        INNER JOIN model_has_roles ON users.id = model_id
        INNER JOIN roles ON roles.id = model_has_roles.role_id
        WHERE users.id = $user->id";

        $rol= DB::select($query);

        if ($rol[0]->id < 3){
            $tiendas = Tienda::where('estado_id', '=', 1)->get();
        }
        else
        {
            $tt = Usuario_Tienda::where("user_id","=",$user->id)->get();
            $tiendas = Tienda::where("id",$tt[0]->tienda_id)->get();

        }

        $companias = Compania::where('id', '<=', 2)->get();

        return view('admin.recargas.createm', compact('companias','tiendas'));
    }


    public function storem(Request $request)
    {
        $data = $request->all();

        $saldos = SaldoRecargas::Where('tienda_id','=',$request->tienda_id)->Where('compania_id','=',$request->compania_id)->OrderBy('id','DESC')->get()->first();

        $salida = $saldos->saldo - $request->saldo;

        if ($salida < 0){
            return redirect()->route('recargas.newm')->withDanger('La venta es negativa, verificar nuevamente sus datos, no se hizo el registro del saldo');
        }
        else
        {
            $recargas = SaldoRecargas::create($data);
        if ($request->compania_id == 1){
            $recargas->producto_id = 353;
        }else{
            $recargas->producto_id = 354;
        }
        $recargas->user_id = Auth::user()->id;
        $recargas->entrada = 0;
        $recargas->salida = $salida;
        $recargas->saldo = $request->saldo;
        $recargas->save();

        $bodega = Bodega::Where("tienda_id","=",$request->tienda_id)->Where("tipo","=",2)->get();

        $pm = PedidoMaestro::create([
            'cliente_id'          => 1,
            'forma_pago_id'       => 1,
            'porcentaje'          => 0,
            'descuento_porcentaje'=> 0,
            'descuento_valores'   => 0,
            'subtotal'            => $salida,
            'total'               => $salida,
            'user_id'             => Auth::user()->id,
            'bodega_id'           => $bodega[0]->id,
            'estado_facturacion'  => 0
        ]);

        $vc = VentaCliente::create([
            'pedido_maestro_id'     => $pm->id,
            'nit'                   => "CF",
            'nombre'                => "Tiendas Melany",
            'direccion'             => "Jalpatagua"
        ]);

        $pd = PedidoDetalle::create([
            'cantidad'          => 1,
            'imei'              => "X",
            'precio'            => $salida,
            'subtotal'          => $salida,
            'producto_id'       => $recargas->producto_id,
            'pedido_maestro_id' => $pm->id
        ]);

         event(new ActualizacionBitacora($recargas->id, Auth::user()->id,'Creación','', $recargas,'Recargas Final del día'));
         return redirect()->route('recargas.index')->withFlash('El saldo ha sido registrado exitosamente!');

        }

        
         
         
    }


    public function createt()
    {
        $user = Auth::user();
        $query = "SELECT roles.id as id
        FROM users
        INNER JOIN model_has_roles ON users.id = model_id
        INNER JOIN roles ON roles.id = model_has_roles.role_id
        WHERE users.id = $user->id";

        $rol= DB::select($query);

        if ($rol[0]->id < 3){
            $tiendas = Tienda::where('estado_id', '=', 1)->get();

            $tiendast = Tienda::where('estado_id', 1)->get();
        }
        else
        {
            $tt = Usuario_Tienda::where("user_id","=",$user->id)->get();
            $tiendas = Tienda::where("id",$tt[0]->tienda_id)->get();

            $tiendast = Tienda::where('estado_id', 1)->where('id', '!=', $tiendas[0]->id)->get();

        }


        $companias = Compania::where('id', '<=', 2)->get();

        return view('admin.recargas.createt', compact('companias','tiendas','tiendast'));
    }



    public function storet(Request $request)
    {
        $data = $request->all();

        $saldosenvia = SaldoRecargas::Where('tienda_id','=',$request->tienda_envia)->Where('compania_id','=',$request->compania_id)->OrderBy('id','DESC')->get()->first();
        $saldosrecibe = SaldoRecargas::Where('tienda_id','=',$request->tienda_recibe)->Where('compania_id','=',$request->compania_id)->OrderBy('id','DESC')->get()->first();


        $recargas = SaldoRecargas::create($data);
        $recargas->tienda_id = $request->tienda_envia;
        $recargas->producto_id = 0;
        $recargas->compania_id = $request->compania_id;
        $recargas->entrada = 0;
        $recargas->salida = $request->total;
        $recargas->saldo = $saldosenvia->saldo - $request->total;
        $recargas->user_id = Auth::user()->id;
        $recargas->save();


        $recargas = SaldoRecargas::create($data);
        $recargas->tienda_id = $request->tienda_recibe;
        $recargas->producto_id = 0;
        $recargas->compania_id = $request->compania_id;
        $recargas->entrada = $request->total;
        $recargas->salida = 0;
        $recargas->saldo = $saldosrecibe->saldo + $request->total;
        $recargas->user_id = Auth::user()->id;
        $recargas->save();

         event(new ActualizacionBitacora($recargas->id, Auth::user()->id,'Creación','', $recargas,'Recargas Final del día'));
         
         return redirect()->route('recargas.index')->withFlash('El saldo ha sido trasladado exitosamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SaldoRecargas $saldorecargas)
    {
        $tiendas = Tienda::where('estado_id', '=', 1)->get();
        $companias = Compania::where('id', '<=', 2)->get();

        return view('admin.recargas.edit', compact('saldorecargas','tiendas','companias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaldoRecargas $saldorecargas)
    {
        $saldorecargas->update($request->all());

        event(new ActualizacionBitacora($saldorecargas->id, Auth::user()->id, 'Edición', '', $saldorecargas, 'Saldo de Recargas'));

        return redirect()->route('recargas.index')->withFlash('El Saldo de la recarga se ha modificado exitosamente');
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
}
