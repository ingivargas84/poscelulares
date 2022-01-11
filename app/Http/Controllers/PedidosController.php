<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\Cliente;
use App\CuentaCobrarDetallePedido;
use App\CuentaCobrarMaestro;
use App\Events\ActualizacionBitacora;
use App\Factura;
use App\FormaPago;
use App\MovimientoProducto;
use App\PedidoDetalle;
use App\PedidoMaestro;
use App\Usuario_Tienda;
use App\Producto;
use App\SaldoRecargas;
use App\NotaEnvio;
use App\Producto_Imei;
use App\VentaCliente;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class PedidosController extends Controller
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
        return view('admin.pedidos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Bodega $bodega)
    {
        $clientes = Cliente::select(
            'clientes.id',
            'clientes.nombre_cliente'
        )->where(
            'clientes.estado','=', 1
        )->get();

        $productos = Producto::select()->where('estado', '=', 1)->get();
        $formas_pago = FormaPago::select()->where('estado', '=', 1)->get();

        if (Auth::user()->id < 3)
        {
            $bodegas = Bodega::Where("estado","=",1)->get();
        }
        else
        {
            $user_tienda = Usuario_Tienda::Where("user_id","=",Auth::user()->id)->get()->first();
            $bodegas = Bodega::Where("tienda_id","=",$user_tienda->tienda_id)->get();
        }

        return view('admin.pedidos.create', compact('clientes', 'productos', 'formas_pago', 'bodegas'));

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
        //dd($arr); //for testing purposes

        //variables from request
        $user_id        = Auth::user()->id;
        $cliente_id     = $arr[1]["value"];
        $forma_pago_id  = $arr[2]["value"];
        $total          = $arr[12]["value"];
        $bodega_id      = $arr[3]["value"];

        $iva = (12 / 100) * $total;
        $subtotal = $total - $iva;

        
          $pm = PedidoMaestro::create([
              'cliente_id' => $cliente_id,
              'forma_pago_id' => $forma_pago_id,
              'total'      => $total,
              'user_id'    => $user_id,
              'bodega_id'  => $bodega_id,
              'estado_facturacion' => 0
          ]);

        event(new ActualizacionBitacora($pm->id, $user_id, 'Creación', '', $pm, 'pedidos_maestro'));

        /* checks if there is an existing account
        for custommer and adds the order ammount
        to the balance, or creates it.        */
        if (!Cliente::find($cliente_id)->CuentaCobrarMaestro) {
            //creates the account master with initial balance of 0
            $ccm = CuentaCobrarMaestro::create([
                'saldo'      => 0,
                'id_cliente' => $cliente_id
            ]);
            event(new ActualizacionBitacora($ccm->id, $user_id, 'Creación', '', $ccm, 'cuentas_cobrar_maestro'));

            //creates the account's order detail
            $ccdp = CuentaCobrarDetallePedido::create([
                'pedido_id' => $pm->id,
                'cuentas_cobrar_maestro_id' => $ccm->id
            ]);
            event(new ActualizacionBitacora($ccdp->id, $user_id, 'Creación', '', $ccdp, 'cuentas_cobrar_detalle_pedido'));

            //increments the account balance by the order total
            $ccm->increment('saldo', $pm->total);

        } else {

            //gets the existing account master
            $ccm = Cliente::find($cliente_id)->CuentaCobrarMaestro;

            //creates the account's order detail
            $ccdp = CuentaCobrarDetallePedido::create([
                'pedido_id' => $pm->id,
                'cuentas_cobrar_maestro_id' => $ccm->id
            ]);
            event(new ActualizacionBitacora($ccdp->id, $user_id, 'Creación', '', $ccdp, 'cuentas_cobrar_detalle_pedido'));
            $ccm->increment('saldo', $pm->total);
        }        

        //creates the order details
        for ($i = 13; $i < sizeof($arr); $i++) {
            $pd = PedidoDetalle::create([
                'cantidad'          => $arr[$i]["cantidad"],
                'imei'              => $arr[$i]["imei"],
                'precio'            => $arr[$i]["precio"],
                'subtotal'          => $arr[$i]["subtotal"],
                'producto_id'       => $arr[$i]["producto_id"],
                'pedido_maestro_id' => $pm->id
            ]);

            $pi = Producto_Imei::WHERE("producto_id","=",$arr[$i]["producto_id"] )->WHERE("bodega_id","=",$bodega_id )->get();
            $pi[0]->estado_venta_id = 2;
            $pi[0]->save();

            event(new ActualizacionBitacora($pd->id, $user_id, 'Creación', '', $pd, 'pedidos_detalle'));

            $count = 0;
            /* gets all the product movement rows for the ordered product
            and puts them ordered by expiration date in an array.   */
            $movimientos = MovimientoProducto::select()->where([
                ['producto_id', $arr[$i]["producto_id"]],
                ['bodega_id', $bodega_id]
            ])->orderBy(
                'caducidad'
            )->get();

            /* decrements the stock of the closest to expire product movement
            row until it reaches 0 or the ordered amount is subtracted  */
            foreach ($movimientos as $mov) {
                while ($mov->existencias != 0 && $count < $arr[$i]["cantidad"]) {
                    $mov->decrement('existencias');
                    $count++;
                }
            }
        }


        return Response::json(['success' => 'éxito']);
    }


    public function createcontado()
    {
        
        $productos = Producto::select()->where('estado', '=', 1)->get();
        $formas_pago = FormaPago::select()->where('estado', '=', 1)->get();

        $user = Auth::user();
        $query = "SELECT roles.id as id
        FROM users
        INNER JOIN model_has_roles ON users.id = model_id
        INNER JOIN roles ON roles.id = model_has_roles.role_id
        WHERE users.id = $user->id";

        $rol= DB::select($query);

        if ($rol[0]->id < 3)
        {
            $bodegas = Bodega::Where("estado","=",1)->get();
        }
        else
        {
            $user_tienda = Usuario_Tienda::Where("user_id","=",Auth::user()->id)->get()->first();
            $bodegas = Bodega::Where("tienda_id","=",$user_tienda->tienda_id)->get();
        }

        return view('admin.pedidos.createcontado', compact('productos', 'formas_pago', 'bodegas'));

    }


    public function storecontado(Request $request)
    {
        //make an array from the request data
        $arr = json_decode($request->getContent(), true);
        
        //variables from request
        $user_id                = Auth::user()->id;
        $cliente_id             = 1;
        $forma_pago_id          = $arr[5]["value"];
        $porcentaje             = $arr[7]["value"];
        $descuento_porcentaje   = ($arr[19]["value"] * $arr[7]["value"]) / 100 ;
        $descuento_valores      = $arr[8]["value"];
        $subtotal               = $arr[18]["value"];
        $total                  = $arr[19]["value"];
        $bodega_id              = $arr[6]["value"];
        
          $pm = PedidoMaestro::create([
              'cliente_id'          => $cliente_id,
              'forma_pago_id'       => $forma_pago_id,
              'porcentaje'          => $porcentaje,
              'descuento_porcentaje'=> $descuento_porcentaje,
              'descuento_valores'   => $descuento_valores,
              'subtotal'            => $subtotal,
              'total'               => $total,
              'user_id'             => $user_id,
              'bodega_id'           => $bodega_id,
              'estado_facturacion'  => 0
          ]);

        event(new ActualizacionBitacora($pm->id, $user_id, 'Creación', '', $pm, 'pedidos_maestro'));

        $vc = VentaCliente::create([
            'pedido_maestro_id'     => $pm->id,
            'nit'                   => $arr[1]["value"],
            'nombre'                => $arr[3]["value"],
            'direccion'             => $arr[4]["value"]
        ]);

        if ($arr[17]["name"] == "subtotalv"){
            $num = 20;
        }
        else
        {
            $num = 19;
        }

        //creates the order details
        for ($i = $num; $i < sizeof($arr); $i++) {
            $pd = PedidoDetalle::create([
                'cantidad'          => $arr[$i]["cantidad"],
                'imei'              => $arr[$i]["imei"],
                'precio'            => $arr[$i]["precio"],
                'subtotal'          => $arr[$i]["subtotalv"],
                'producto_id'       => $arr[$i]["producto_id"],
                'pedido_maestro_id' => $pm->id
            ]);

            $pro = Producto::Where("id","=",$arr[$i]["producto_id"])->get();

            if ($pro[0]->presentacion <= 2)
            {
                $pi = Producto_Imei::WHERE("imei","=",$arr[$i]["imei"] )->get();
                $pi[0]->estado_venta_id = 2;
                $pi[0]->save();
            }
            

            event(new ActualizacionBitacora($pd->id, $user_id, 'Creación', '', $pd, 'pedidos_detalle'));

            $count = 0;
            /* gets all the product movement rows for the ordered product
            and puts them ordered by expiration date in an array.   */
            $movimientos = MovimientoProducto::select()->where([
                ['producto_id', $arr[$i]["producto_id"]],
                ['bodega_id', $bodega_id]
            ])->orderBy(
                'caducidad'
            )->get();

            /* decrements the stock of the closest to expire product movement
            row until it reaches 0 or the ordered amount is subtracted  */
            foreach ($movimientos as $mov) {
                while ($mov->existencias != 0 && $count < $arr[$i]["cantidad"]) {
                    $mov->decrement('existencias');
                    $count++;
                }
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
        $pm = $api_result['data'] = PedidoMaestro::select(
            'pedidos_maestro.fecha_ingreso as fecha',
            'pedidos_maestro.total',
            'pedidos_maestro.no_pedido',
            'pedidos_maestro.porcentaje',
            'pedidos_maestro.descuento_porcentaje',
            'pedidos_maestro.descuento_valores',
            'pedidos_maestro.subtotal',
            'pedidos_maestro.id',
            'bodegas.nombre as bodega',
            'formas_pago.nombre as forma_pago',
            'ventas_clientes.nit',
            'ventas_clientes.nombre',
            'ventas_clientes.direccion',
            'users.username as vendedor'
        )->join(
            'ventas_clientes',
            'pedidos_maestro.id',
            '=',
            'ventas_clientes.pedido_maestro_id'
        )->join(
            'users',
            'pedidos_maestro.user_id',
            '=',
            'users.id'
        )->join(
            'bodegas',
            'pedidos_maestro.bodega_id',
            '=',
            'bodegas.id'
        )->join(
            'formas_pago',
            'pedidos_maestro.forma_pago_id',
            '=',
            'formas_pago.id'
        )->where(
            'pedidos_maestro.id',
            '=',
            $id
        )->get();


        $pd = $api_result['data'] = PedidoDetalle::select(
            'pedidos_detalle.id',
            'pedidos_detalle.cantidad',
            'pedidos_detalle.precio',
            'pedidos_detalle.subtotal',
            'pedidos_detalle.imei',
            'productos.descripcion as producto'
        )->join(
            'productos',
            'pedidos_detalle.producto_id',
            '=',
            'productos.id'
        )->where(
            'pedidos_detalle.pedido_maestro_id',
            '=',
            $id
        )->get();

        return view('admin.pedidos.show', compact('pm', 'pd'));
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
    public function destroy(PedidoMaestro $pedidoMaestro, Request $request)
    {
        //get the warehouse id
        $bodega_id = $request->bodega_id;
        //disable the master
        $pedidoMaestro->update(["estado" => 2]);

        //report the deletion to the log
        event(new ActualizacionBitacora(
            $pedidoMaestro->id,
            Auth::user()->id,
            'Eliminación',
            '',
            '',
            'pedidos_maestro'
        ));
        
        //update the account details
        // $pedidoMaestro->cuentaCobrarDetallePedido->cuentaCobrarMaestro->decrement('saldo', $pedidoMaestro->total);
        // $pedidoMaestro->cuentaCobrarDetallePedido->update(['estado'=> 2]);

        //get al the master's details
        $detalles = $pedidoMaestro->pedidosDetalle()->get();
        //walk the details array, disable, report to log and fix stock
        foreach ($detalles as $detalle) {
            //subtract detail subtotal from master total
            $pedidoMaestro->decrement('total', $detalle->subtotal);
            //disable the detail
            $detalle->update(['estado' => 2]);
            // report the deletion to the log

            $pi = Producto_Imei::WHERE("imei","=",$detalle->imei )->get();
            $pi[0]->estado_venta_id = 1;
            $pi[0]->save();

            event(new ActualizacionBitacora(
                $detalle->id,
                Auth::user()->id,
                'Eliminación',
                '',
                '',
                'pedidos_detalle'
            ));
            //get all the movements relevant to the detail
            $movimientos = MovimientoProducto::select()->where([
                ['producto_id', $detalle->producto_id],
                ['bodega_id', $pedidoMaestro->bodega_id]
            ])->orderBy(
                'caducidad'
            )->get();
            //add to movement
            $count = 0;

            foreach ($movimientos as $mov) {
                while ($count < $detalle->cantidad) {
                    $mov->increment('existencias');
                    $count++;
                }
            }

            $imeis = Producto_Imei::where("imei",$detalle->imei)->get();
            $imeis[0]->estado_venta_id = 1;
            $imeis[0]->save();


        }


        return Response::json(['success' => 'éxito']);
    }

    /**
     * destroyDetail
     *
     * destroys a detail from a master. Disables mastes
     * if disabled detail is last.
     *
     * @param PedidoDetalle $pedidoDetalle
     * @param Request $request
     * @return void
     */
    public function destroyDetalle(PedidoDetalle $pedidoDetalle, Request $request)
    {
        $maestro = $pedidoDetalle->pedidoMaestro;

        //get all the relevant movimiento_producto for the $pedidoDetalle
        $movimientos = MovimientoProducto::select()->where([
            ['producto_id', $pedidoDetalle->producto_id],
            ['bodega_id', $maestro->bodega_id]
        ])->orderBy(
            'caducidad'
        )->get();

        //this variable is to be compared with the added amount
        $count = 0;

        if (sizeOf($pedidoDetalle->pedidoMaestro()->get()[0]->pedidosDetalle->where('estado', '=', 1)) > 1) {
            //desactivar detalle
            $pedidoDetalle->update(["estado" => 2]);
            //restar del total
            $pedidoDetalle->pedidoMaestro()->get()[0]->decrement("total", $pedidoDetalle->subtotal);
            //actualizar cuentas por cobrar
            $ccm = Cliente::find($maestro->cliente_id)->CuentaCobrarMaestro;
            $ccm->decrement('saldo', $pedidoDetalle->subtotal);
            //actualizar bitácora
            event(new ActualizacionBitacora(
                $pedidoDetalle->id,
                Auth::user()->id,
                'Eliminación',
                '',
                '',
                'pedidos_detalle'
            ));

            //sumar al movimiento_productos
            foreach ($movimientos as $mov) {
                while ($mov->existencias != 0 && $count < $pedidoDetalle->cantidad) {
                    $mov->increment('existencias');
                    $count++;
                }
            }
            return Response::json(['success' => 'Éxito']);
        } else {
            //desactivar detalle
            $pedidoDetalle->update(["estado" => 2]);
            //restar del total
            $pedidoDetalle->pedidoMaestro()->get()[0]->decrement("total", $pedidoDetalle->subtotal);
            //desactivar $pedidoDetalle->pedidoMaestro
            $pedidoDetalle->pedidoMaestro()->get()[0]->update(["estado" => 2]);
            //actualizar cuentas por cobrar
            $ccm = Cliente::find($maestro->cliente_id)->CuentaCobrarMaestro;
            $ccm->decrement('saldo', $pedidoDetalle->subtotal);
            //actualizar bitácora
            event(new ActualizacionBitacora(
                $pedidoDetalle->id,
                Auth::user()->id,
                'Eliminación',
                '',
                '',
                'pedidos_detalle'
            ));
            event(new ActualizacionBitacora(
                $pedidoDetalle->pedidoMaestro()->get()[0]->id,
                Auth::user()->id,
                'Eliminación',
                '',
                '',
                'pedidos_maestro'
            ));

            //sumar al movimiento_productos
            foreach ($movimientos as $mov) {
                while ($mov->existencias != 0 && $count < $pedidoDetalle->cantidad) {
                    $mov->increment('existencias');
                    $count++;
                }
            }
            //sends a successful response with a return value
            return Response::json([
                'success' => 'Éxito',
                'back'   => 'true'
            ]);
        }
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
            $api_result['data'] = PedidoMaestro::select(
                'pedidos_maestro.fecha_ingreso as fecha',
                'pedidos_maestro.total',
                'pedidos_maestro.id',
                'pedidos_maestro.bodega_id',
                'pedidos_maestro.no_pedido',
                'ne.id as nota_envio',
                'bodegas.nombre as bodega',
                'ne.estado as estado_nota',
                'ventas_clientes.nombre as cliente',
                'users.username as vendedor'
            )->leftJoin(
                /*
                Ok, so what i'm essentially doing here is treating a selection with only
                the active notas_envio rows as a table. Basically treating the soft deleted
                rows as if they were hard deleted and forcing the 'nota_envio' and
                'estado_nota' fields to be null with the left join.
                */
                DB::raw(
                    '(select * from notas_envio where notas_envio.estado = 1) ne'
                ),
                function ($join) {
                    $join->on(
                        'ne.pedido_id',
                        '=',
                        'pedidos_maestro.id'
                    );
                }
            )->join(
                'ventas_clientes',
                'pedidos_maestro.id',
                '=',
                'ventas_clientes.pedido_maestro_id'
            )->join(
                'bodegas',
                'pedidos_maestro.bodega_id',
                '=',
                'bodegas.id'
            )->join(
                'users',
                'pedidos_maestro.user_id',
                '=',
                'users.id'
            )->where(
                'pedidos_maestro.estado',
                '=',
                1
            )->get();
        }
        else
        {
            $api_result['data'] = PedidoMaestro::select(
                'pedidos_maestro.fecha_ingreso as fecha',
                'pedidos_maestro.total',
                'pedidos_maestro.id',
                'pedidos_maestro.bodega_id',
                'pedidos_maestro.no_pedido',
                'ne.id as nota_envio',
                'bodegas.nombre as bodega',
                'ne.estado as estado_nota',
                'ventas_clientes.nombre as cliente',
                'users.username as vendedor'
            )->leftJoin(
                /*
                Ok, so what i'm essentially doing here is treating a selection with only
                the active notas_envio rows as a table. Basically treating the soft deleted
                rows as if they were hard deleted and forcing the 'nota_envio' and
                'estado_nota' fields to be null with the left join.
                */
                DB::raw(
                    '(select * from notas_envio where notas_envio.estado = 1) ne'
                ),
                function ($join) {
                    $join->on(
                        'ne.pedido_id',
                        '=',
                        'pedidos_maestro.id'
                    );
                }
            )->join(
                'ventas_clientes',
                'pedidos_maestro.id',
                '=',
                'ventas_clientes.pedido_maestro_id'
            )->join(
                'bodegas',
                'pedidos_maestro.bodega_id',
                '=',
                'bodegas.id'
            )->join(
                'users',
                'pedidos_maestro.user_id',
                '=',
                'users.id'
            )->where(
                'pedidos_maestro.estado',
                '=',
                1
            )->where(
                'pedidos_maestro.user_id',
                '=',
                Auth::user()->id
            )->get();
        }

        return Response::json($api_result);
    }


    //get the details for the invoice
    public function getDetalles(Request $params, PedidoMaestro $pedidoMaestro)
    {
        $api_result['data'] = $pedidoMaestro->pedidosDetalle()->join(
            'productos',
            'pedidos_detalle.producto_id',
            'productos.id'
        )->select(
            'pedidos_detalle.id',
            'pedidos_detalle.cantidad',
            'pedidos_detalle.precio',
            'pedidos_detalle.subtotal',
            'productos.nombre_comercial as producto',
            'productos.codigo',
            'pedidos_detalle.estado'
        )->where(
            'pedidos_detalle.estado',
            '=',
            '1'
        )->get();
        return Response::json($api_result);
    }


    //get the details for the invoice
    public function getDetalles1(Request $params, PedidoMaestro $pedidoMaestro)
    {
        $query = "SELECT pedidos_detalle.id, pedidos_detalle.cantidad, pedidos_detalle.precio, pedidos_detalle.subtotal, productos.nombre_comercial as producto,
        productos.codigo
        FROM pedidos_detalle
        INNER JOIN pedidos_maestro on pedidos_detalle.pedido_maestro_id = pedidos_maestro.id
        INNER JOIN facturas ON facturas.pedido_maestro_id = pedidos_maestro.id
        INNER JOIN productos ON productos.id = pedidos_detalle.producto_id
        WHERE pedidos_detalle.estado = 1 AND facturas.id = $pedidoMaestro->id ";
        $api_result['data'] = DB::select($query);
        return Response::json($api_result);
    }


    //get the selected product data for the create view
    public function getProductoData($id, Bodega $bodega)
    {
        $api_result = Producto::select(
            'productos.descripcion',
            'productos.presentacion as grupo',
            'productos.id',
            'productos.precio_venta',
            'presentaciones_producto.presentacion',
            DB::raw('SUM(movimientos_producto.existencias) as existencias')
        )->join(
            'presentaciones_producto',
            'presentaciones_producto.id',
            '=',
            'productos.presentacion'
        )->join(
            'movimientos_producto',
            'movimientos_producto.producto_id',
            '=',
            'productos.id'
        )->where([
            ['productos.id','=',$id],
            ['movimientos_producto.bodega_id', '=', $bodega->id]
        ])->groupBy(
            'productos.id',
            'productos.codigo',
            'productos.presentacion',
            'productos.descripcion',
            'productos.precio_venta',
            'presentaciones_producto.presentacion'
        )->get();

        return Response::json($api_result);
    }


    public function getImei($id, Bodega $bodega)
    {
        $api_result = Producto_Imei::select(
            'id',
            'imei'
        )->where(
            'producto_id',
            '=',
            $id
        )->where(
            'bodega_id',
            '=',
            $bodega->id
        )->where(
            'estado_venta_id',
            '=',
             1
        )->get();

        return Response::json($api_result);
    }


    //get the selected product data for the create view
    public function getProductoData1($codigo, Bodega $bodega)
    {
        $api_result = Producto::select(
            'productos.nombre_comercial',
            'productos.id',
            'productos.precio_venta',
            'presentaciones_producto.presentacion',
            DB::raw('SUM(movimientos_producto.existencias) as existencias')
        )->join(
            'presentaciones_producto',
            'presentaciones_producto.id',
            '=',
            'productos.presentacion'
        )->join(
            'movimientos_producto',
            'movimientos_producto.producto_id',
            '=',
            'productos.id'
        )->where([
            ['productos.nombre_comercial','=',$codigo, 'or', 'productos.codigo','=',$codigo ],
            ['movimientos_producto.bodega_id', '=', $bodega->id]
        ])->where(
          'productos.estado',
          '=',
          '1'
          )->groupBy(
            'productos.id',
            'productos.codigo',
            'productos.nombre_comercial',
            'productos.precio_venta',
            'presentaciones_producto.presentacion'
        )->get();

        return Response::json($api_result);
    }


    public function getFactura($id)
    {
        $api_result = Factura::select(
            'facturas.id',
            'facturas.fecha_factura',
            'facturas.serie_factura',
            'facturas.no_factura',
            'facturas.subtotal',
            'facturas.impuestos',
            'facturas.total',
            'clientes.id as cliente_id',
            'clientes.nombre_cliente',
            'clientes.nit',
            'clientes.direccion',
            'clientes.dias_credito',
            'clientes.telefono_compras',
            'users.name as vendedor'
        )->join(
            'pedidos_maestro',
            'facturas.pedido_maestro_id',
            'pedidos_maestro.id'
        )->join(
            'clientes',
            'pedidos_maestro.cliente_id',
            'clientes.id'
        )->join(
            'users',
            'users.id',
            'pedidos_maestro.user_id'
        )->where(
            'facturas.id',
            '=',
            $id
        )->get();

        return Response::json($api_result);
    }



    public function store1(Request $request)
    {
        //make an array from the request data
        $arr = json_decode($request->getContent(), true);
        // dd($arr); //for testing purposes

        //variables from request
        $user_id    = Auth::user()->id;
        $cliente_id = $arr[1]["value"];
        $total      = $arr[14]["value"];
        $api_result = $arr[13]["value"];
      //  $serie      = $arr[13]["value"];
      //  $no_factura = $arr[14]["value"];
        $bodega_id  = $arr[2]["value"];
        $id_pedido_maestro = $arr[0]["value"];
        $iva = (12 / 100) * $total;
        $subtotal = $total - $iva;

        //actualizaion del total
        $pm = PedidoMaestro::where('id', $id_pedido_maestro )->get()->first();
        $total_maestro =  $pm->total;
        $total_maestro = $total - $total_maestro;
        $pm->total = $total;
        $pm->save();

        event(new ActualizacionBitacora($pm->id, $user_id, 'Actualizacion', '', $pm, 'pedidos_maestro'));



            //gets the existing account master
            $ccm = Cliente::find($cliente_id)->CuentaCobrarMaestro;

            //creates the account's order detail
        /*    $ccdp = CuentaCobrarDetallePedido::create([
                'pedido_id' => $pm->id,
                'cuentas_cobrar_maestro_id' => $ccm->id
            ]);
            event(new ActualizacionBitacora($ccdp->id, $user_id, 'Creación', '', $ccdp, 'cuentas_cobrar_detalle_pedido'));*/
            $ccm->increment('saldo', $total_maestro);


        //creates the order details
        for ($i = 15; $i < sizeof($arr); $i++) {
            $pd = PedidoDetalle::create([
                'cantidad'          => $arr[$i]["cantidad"],
                'precio'            => $arr[$i]["precio"],
                'subtotal'          => $arr[$i]["subtotal"],
                'producto_id'       => $arr[$i]["producto_id"],
                'pedido_maestro_id' => $pm->id
            ]);
            event(new ActualizacionBitacora($pd->id, $user_id, 'Creación', '', $pd, 'pedidos_detalle'));

            $count = 0;
            /* gets all the product movement rows for the ordered product
            and puts them ordered by expiration date in an array.   */
            $movimientos = MovimientoProducto::select()->where([
                ['producto_id', $arr[$i]["producto_id"]],
                ['bodega_id', $bodega_id]
            ])->orderBy(
                'caducidad'
            )->get();

            /* decrements the stock of the closest to expire product movement
            row until it reaches 0 or the ordered amount is subtracted  */
            foreach ($movimientos as $mov) {
                while ($mov->existencias != 0 && $count < $arr[$i]["cantidad"]) {
                    $mov->decrement('existencias');
                    $count++;
                }
            }
        }

        if ($api_result === 'true') {
          $cli = Cliente::find($cliente_id);



          $ne = NotaEnvio::create([
              'cliente'   => $cli->nombre_cliente,
              'direccion' => $cli->direccion,
              'telefono'  => 'sin telefono',
              'pedido_id' => $pm->id,
          ]);

          event(new ActualizacionBitacora($ne->id, Auth::user()->id, 'Creación', '', $ne, 'notas_envio'));


                    $query = "SELECT users.name as name, users.id as id
                    FROM users
                    where id = $user_id";

                    $u = DB::select($query);

                    //envio de correo
                    $subject = "Nuevo pedido con facturación creado";
                    $for = "marielosdelangel@hotmail.com";
                    Mail::send('admin.pedidos.correo',['nota' => $ne->no_nota_envio, 'cliente' => $cli->nombre_cliente, 'total' => $total, 'vendedor' => $u[0]->name], function($msj) use($subject,$for){
                        $msj->from("info@distribuidoraelangel.com","Distribuidora El Angel");
                        $msj->subject($subject);
                        $msj->to($for);
                    });
       }

        return Response::json(['success' => 'éxito']);
    }



    public function editarDetalle($id){

      $detalle = PedidoDetalle::select(
        'productos.nombre_comercial as producto',
        'pedidos_detalle.cantidad as cantidad',
        'pedidos_detalle.subtotal as subtotal',
        'pedidos_detalle.precio as precio',
        'productos.codigo as productoid',
        'productos.id as id',
        'pedidos_maestro.bodega_id as bodega'
        )->join(
          'productos',
          'productos.id',
          '=',
          'pedidos_detalle.producto_id'
          )->join(
            'pedidos_maestro',
            'pedidos_maestro.id',
            '=',
            'pedidos_detalle.pedido_maestro_id'
            )->WHERE(
          'pedidos_detalle.id',
          '=',
          $id
          )->get();
        return Response::json($detalle);
    }




    public function actulizarDetalle(Request $request)
    {
      $detalle = PedidoDetalle::find($request->idDetalle);
      if (  $detalle->subtotal > $request->subtotaldetalle) {
        //actualizaion del total
        $pm = PedidoMaestro::where('id', $detalle->pedido_maestro_id )->get()->first();
        $total_maestro = $detalle->subtotal - $request->subtotaldetalle;
        $pm->total -= $total_maestro;
        $pm->save();
        $ccm = Cliente::find($pm->cliente_id)->CuentaCobrarMaestro;
        $ccm->increment('saldo', $total_maestro);
      }else {
        //actualizaion del total
        $pm = PedidoMaestro::where('id', $detalle->pedido_maestro_id )->get()->first();
        $total_maestro = $request->subtotaldetalle - $detalle->subtotal;
        $pm->total += $total_maestro;
        $pm->save();
        $ccm = Cliente::find($pm->cliente_id)->CuentaCobrarMaestro;
        $ccm->increment('saldo', $total_maestro);
      }


      if ($request->cantidaddetalle >  $detalle->cantidad) {
        $t = $request->cantidaddetalle - $detalle->cantidad;
        $count = 0;
        /* gets all the product movement rows for the ordered product
        and puts them ordered by expiration date in an array.   */
        $movimientos = MovimientoProducto::select()->where([
            ['producto_id', $request->idproductodetalle],
            ['bodega_id', $request->bodegadetalle]
        ])->orderBy(
            'caducidad'
        )->get();

        /* decrements the stock of the closest to expire product movement
        row until it reaches 0 or the ordered amount is subtracted  */
        foreach ($movimientos as $mov) {
            while ($mov->existencias != 0 && $count < $t) {
                $mov->decrement('existencias');
                $count++;
            }
        }
      }else {
          $t1 = $detalle->cantidad - $request->cantidaddetalle;
        $count = 0;
        /* gets all the product movement rows for the ordered product
        and puts them ordered by expiration date in an array.   */
        $movimientos = MovimientoProducto::select()->where([
            ['producto_id', $request->idproductodetalle],
            ['bodega_id', $request->bodegadetalle]
        ])->orderBy(
            'caducidad'
        )->get();
        /* decrements the stock of the closest to expire product movement
        row until it reaches 0 or the ordered amount is subtracted  */
        foreach ($movimientos as $mov) {
            while ($mov->existencias != 0 && $count < $t1) {
                $mov->increment('existencias');
                $count++;
            }
        }
      }

      $detalle->cantidad = $request->cantidaddetalle;
      $detalle->subtotal = $request->subtotaldetalle;
      $detalle->save();
      return Response::json(['success' => 'Éxito']);
    }



    public function getPedidos(){
      $pedidos = PedidoMaestro::select(
            'pedidos_maestro.id as id',
            'pedidos_maestro.no_pedido as numero',
            'pedidos_maestro.total as monto',
            'clientes.nombre_cliente as cliente'
        )->join(
            'clientes',
            'clientes.id', '=', 'pedidos_maestro.cliente_id'
          )->get();
          return Response::json($pedidos);
    }



    public function devolucion(Request $request){
      $bodega = Bodega::where('estado','=','1')->get();
      $id = $request->pedido1;
      $cliente = PedidoMaestro::where('id', '=', $id)->get();
      return view('admin.devoluciones.index', compact('bodega','id', 'cliente'));
    }




    public function devoluciones($id)
    {
        $query = "SELECT pedidos_detalle.id as id, pedidos_detalle.cantidad as cantidad, pedidos_detalle.precio as precio, pedidos_detalle.subtotal as subtotal, productos.nombre_comercial as producto,
        productos.id as idproducto, 0 as restar, 0 as posicion, pedidos_maestro.id as maestro
        FROM pedidos_detalle
        INNER JOIN pedidos_maestro on pedidos_detalle.pedido_maestro_id = pedidos_maestro.id
        INNER JOIN productos ON productos.id = pedidos_detalle.producto_id
        WHERE pedidos_detalle.estado = 1 AND pedidos_maestro.id = $id ";
        $api_result['data'] = DB::select($query);
        return Response::json($api_result);
    }



    public function storeDevoluciones(Request $request){
      $arr = json_decode($request->getContent(), true);

      $user_id = Auth::user()->id;
      $bodega = $arr[0]["value"];
      $maestro = $arr[1]["value"];
      $cliente = $arr[2]["value"];


      //creates the order details
      for ($i = 3; $i < sizeof($arr); $i++) {
        $can =  $arr[$i]["cantidad"] * (-1);
        $pd = PedidoDetalle::create([
            'cantidad'          => $can,
            'precio'            => $arr[$i]["precio"],
            'subtotal'          => $arr[$i]["subtotal"],
            'producto_id'       => $arr[$i]["idproducto"],
            'pedido_maestro_id' => $arr[$i]["maestro"]
        ]);
        $total = PedidoMaestro::find($maestro);
        $total->total = $total->total + ($arr[$i]["subtotal"]);
        $total->save();
          $count = 0;
          /* gets all the product movement rows for the ordered product
          and puts them ordered by expiration date in an array.   */
          $movimientos = MovimientoProducto::select()->where([
              ['producto_id', $arr[$i]["idproducto"]],
              ['bodega_id', $bodega]
          ])->get();

          /* decrements the stock of the closest to expire product movement
          row until it reaches 0 or the ordered amount is subtracted  */
          foreach ($movimientos as $mov) {
              while ($mov->existencias >= 0 && $count < $arr[$i]["cantidad"]) {
                  $mov->increment('existencias');
                  $count++;
              }
          }
      }

      //gets the existing account master
      $ccm = Cliente::find($cliente)->CuentaCobrarMaestro;
      $ccm->decrement('saldo', $total->total);
      return Response::json(['success' => 'éxito']);
          //    return redirect()->route('pedidos.index')->withFlash('Dwvolución realizada');

    }
}
