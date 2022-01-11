<?php

namespace App\Http\Controllers;

use App\Events\ActualizacionBitacora;
use App\Factura;
use App\FacturaDetalle;
use App\PedidoMaestro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class FacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.facturas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ventas = PedidoMaestro::where('estado', '=', 1)->where('fecha_ingreso', '=', Carbon::today() )->where('estado_facturacion', '=',0 )->get();

        return view('admin.facturas.create', compact('ventas'));
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

       $fecha_factura           = $arr[6]["value"];
       $serie_factura           = $arr[7]["value"];
       $no_factura              = $arr[8]["value"];
       $subtotal                = $arr[9]["value"];
       $impuestos               = $arr[10]["value"];
       $total                   = $arr[11]["value"];
       $nit                     = $arr[3]["value"];
       $direccion               = $arr[5]["value"];
       $nombre_factura          = $arr[4]["value"];
       $motivo_anulacion        = null;
       $estado                  = 1;
       $pedido_maestro_id       = $arr[1]["value"];
       $user_id                 = Auth::user()->id;

         $fm = Factura::create([
             'fecha_factura'        => $fecha_factura,
             'serie_factura'        => $serie_factura,
             'no_factura'           => $no_factura,
             'subtotal'             => $subtotal,
             'impuestos'            => $impuestos,
             'total'                => $total,
             'nit'                  => $nit,
             'direccion'            => $direccion,
             'nombre_factura'       => $nombre_factura,
             'motivo_anulacion'     => $motivo_anulacion,
             'user_anulacion'       => 1,
             'estado'               => $estado,
             'pedido_maestro_id'    => $pedido_maestro_id,
             'user_id'              => $user_id
         ]);

       event(new ActualizacionBitacora($fm->id, $user_id, 'Creación', '', $fm, 'facturas_maestro'));

        $pedm = PedidoMaestro::WHERE("id","=", $pedido_maestro_id)->get();
        $pedm[0]->estado_facturacion = 1;
        $pedm[0]->save();

       //creates the order details
       for ($i = 12; $i < sizeof($arr); $i++) {
           $fd = FacturaDetalle::create([
            'factura_id'        => $fm->id,
            'producto_id'       => $arr[$i]["producto_id"],
            'descripcion'       => $arr[$i]["producto"],
            'imei'              => $arr[$i]["imei"],
            'numero_tel'        => null,
            'cantidad'          => $arr[$i]["cantidad"],
            'precio_unitario'   => $arr[$i]["precio_unitario"],
            'subtotal'          => $arr[$i]["subtotal"]
           ]);

           event(new ActualizacionBitacora($fd->id, $user_id, 'Creación', '', $fd, 'facturas_detalle'));
        }

      return Response::json(['success'=>'éxito']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $factura = Factura::select(
            'facturas.id',
            'facturas.serie_factura',
            'facturas.no_factura',
            'facturas.subtotal',
            'facturas.impuestos',
            'facturas.total',
            'facturas.nit',
            'facturas.direccion',
            'facturas.nombre_factura',
            'facturas.motivo_anulacion',
            'facturas.fecha_anulacion',
            'facturas.estado',
            'facturas.created_at',
            'estados.estado as estado_fac',
            'us.name as us_crea',
            'usanula.name as us_anula',
        )->join(
            'pedidos_maestro',
            'facturas.pedido_maestro_id',
            '=',
            'pedidos_maestro.id'
        )->join(
            'estados',
            'pedidos_maestro.estado',
            '=',
            'estados.id'
        )->join(
            'users as us',
            'facturas.user_id',
            '=',
            'us.id'
        )->join(
            'users as usanula',
            'facturas.user_anulacion',
            '=',
            'usanula.id'
        )->where(
            'facturas.id',
            '=',
            $id
        )->get();


        $facturadetalle = FacturaDetalle::select(
            'facturas_detalle.id',
            'facturas_detalle.descripcion',
            'facturas_detalle.imei',
            'facturas_detalle.numero_tel',
            'facturas_detalle.cantidad',
            'facturas_detalle.precio_unitario',
            'facturas_detalle.subtotal'
        )->where(
            'facturas_detalle.factura_id',
            '=',
            $id
        )->get();

        return view('admin.facturas.show', compact('factura','facturadetalle'));
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

    public function delete($id, Request $request)
    {
        $factura = Factura::find($id);

        return view('admin.facturas.delete', compact('factura'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $factura = Factura::WHERE("id","=", $request->factura_id)->get();
        $factura[0]->motivo_anulacion = $request->motivo_anulacion;
        $factura[0]->estado = 4;
        $factura[0]->fecha_anulacion = Carbon::now();
        $factura[0]->user_anulacion = Auth::user()->id;
        $factura[0]->save();


            event(new ActualizacionBitacora($factura[0]->id, Auth::user()->id, 'Anulación', '', '', 'facturas'));

            return view('admin.facturas.index');

    }

    public function getJson(){
        $data['data'] = Factura::select(
            'facturas.id',
            'facturas.no_factura',
            'facturas.serie_factura',
            'facturas.nombre_factura as cliente',
            'facturas.fecha_factura as fecha',
            'facturas.total',
            'estados.estado'
        )->join(
            'estados',
            'facturas.estado',
            '=',
            'estados.id'
        )->get();

        return Response::json($data);
    }

    public function getPedidos(){
       $query = " SELECT *
                  FROM pedidos_maestro
                  WHERE (id NOT IN (SELECT pedido_maestro_id FROM facturas) or id IN (SELECT pedido_maestro_id FROM facturas where estado = 2) and id NOT IN (SELECT pedido_maestro_id FROM facturas WHERE estado = 1))
                  AND estado_facturacion = 2";
       $pedidos= DB::select($query);
       return Response::json($pedidos);
    }

    public function InformacionCliente($id){
      $cliente = PedidoMaestro::select(
            'pedidos_maestro.total as total',
            'clientes.nit as  nit',
            'clientes.nombre_cliente',
            'clientes.direccion as direccion'
        )->join(
            'clientes',
            'clientes.id',
            '=',
            'pedidos_maestro.cliente_id'
          )->where(
              'pedidos_maestro.id',
              '=',
              $id
            )->get();
        return Response::json($cliente);
    }

    public function noFacturaDisponible(){
       $factura = Input::get("factura");
       $query = Factura::where('no_factura', $factura)->get();
       $contador = count($query);
       if ($contador == 0) {
           return 'false';
       } else {
           return 'true';
       }
    }

    public function noSerieDisponible(){
       $serie = Input::get("serie");
       $factura = Input::get("factura");
       $f = $serie.$factura;
       $query = "SELECT concat_ws('', serie_factura, no_factura) FROM facturas
       WHERE (concat_ws('', serie_factura, no_factura)) = '$f'";
       $facturas = DB::select($query);
       $contador = count($facturas);
       if ($contador == 0) {
           return 'false';
       } else {
           return 'true';
       }

    }

        public function NuevaFactura($id){
          

            $factura = Factura::select(
                'facturas.id',
                'facturas.serie_factura',
                'facturas.no_factura',
                'facturas.subtotal',
                'facturas.impuestos',
                'facturas.total',
                'facturas.nit',
                'facturas.direccion',
                'facturas.nombre_factura',
                'facturas.motivo_anulacion',
                'facturas.fecha_anulacion',
                'facturas.estado',
                'facturas.created_at',
                'estados.estado as estado_fac',
                'us.name as us_crea',
                'usanula.name as us_anula',
            )->join(
                'pedidos_maestro',
                'facturas.pedido_maestro_id',
                '=',
                'pedidos_maestro.id'
            )->join(
                'estados',
                'pedidos_maestro.estado',
                '=',
                'estados.id'
            )->join(
                'users as us',
                'facturas.user_id',
                '=',
                'us.id'
            )->join(
                'users as usanula',
                'facturas.user_anulacion',
                '=',
                'usanula.id'
            )->where(
                'facturas.id',
                '=',
                $id
            )->get();
    
    
            $facturadetalle = FacturaDetalle::select(
                'facturas_detalle.id',
                'facturas_detalle.descripcion',
                'facturas_detalle.imei',
                'facturas_detalle.numero_tel',
                'facturas_detalle.cantidad',
                'facturas_detalle.precio_unitario',
                'facturas_detalle.subtotal'
            )->where(
                'facturas_detalle.factura_id',
                '=',
                $id
            )->get();


          $pdf = \PDF::loadView('admin.facturas.factura', compact('factura', 'facturadetalle'));
          return $pdf->download('factura.pdf');
        }


        public function getVentaData($id)
        {

        $api_result = PedidoMaestro::select(
            'pedidos_maestro.id',
            'ventas_clientes.nit',
            'ventas_clientes.nombre',
            'ventas_clientes.direccion',
            'pedidos_maestro.fecha_ingreso',
            'pedidos_maestro.total',
            'pedidos_detalle.cantidad',
            'pedidos_detalle.producto_id',
            'pedidos_detalle.precio',
            'pedidos_detalle.subtotal',
            'productos.descripcion as producto',
            'pedidos_detalle.imei'
        )->join(
            'ventas_clientes',
            'pedidos_maestro.id',
            '=',
            'ventas_clientes.pedido_maestro_id'
        )->join(
            'pedidos_detalle',
            'pedidos_maestro.id',
            '=',
            'pedidos_detalle.pedido_maestro_id'
        )->join(
            'productos',
            'pedidos_detalle.producto_id',
            '=',
            'productos.id'
        )->where(
            'pedidos_maestro.id',
            '=',
            $id
        )->get();

        return Response::json($api_result);
        }
}
