<?php

namespace App\Http\Controllers;

use App\CuentaCobrarDetalleAbono;
use App\Factura;
use App\IngresoMaestro;
use App\PedidoMaestro;
use Illuminate\Http\Request;
use App\User;
use App\Visita;
use App\Bodega;
use App\Usuario_Tienda;
use App\Gasto;
use App\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if($user->hasRole('Administrador') || $user->hasRole('Super-Administrador')){

            $date = date_format(date_create(), 'Y-m-d');
            $compras  = number_format((float)IngresoMaestro::where('estado_ingreso', 1)->whereDate('created_at', $date)->sum('total_ingreso'), 2, '.', '');
            $ventas   = number_format((float)PedidoMaestro::where('estado', 1)->whereDate('fecha_ingreso', $date)->sum('total'), 2, '.', '');
            $gastos   = number_format((float)Gasto::where('estado_id', 1)->whereDate('created_at', $date)->sum('monto'), 2, '.', '');
            $facturacion = 0;

            $query ="SELECT prod.id, prod.descripcion, SUM(mp.existencias) AS existencias, 
            (SELECT AVG(precio_compra)
            FROM ingresos_detalle
            WHERE producto_id = prod.id ) AS precio
            FROM productos prod
            INNER JOIN movimientos_producto mp ON mp.producto_id=prod.id
            GROUP BY prod.id, prod.descripcion
            HAVING SUM(mp.existencias) > 0
            ORDER BY prod.id ASC";
            $inversion = DB::select($query);

            $ganancias = 0;

            $query1 = "SELECT prod.descripcion, SUM(pd.cantidad) AS total
            FROM pedidos_detalle pd
            INNER JOIN productos prod ON pd.producto_id=prod.id
            WHERE prod.presentacion IN (1,2,6) AND Month(pd.created_at) = Month(NOW())
            GROUP BY prod.descripcion
            ORDER BY total DESC
            LIMIT 10";
            $top5_prods = DB::select($query1);

            $query2 = "SELECT prod.descripcion, SUM(pd.cantidad) AS total
            FROM pedidos_detalle pd
            INNER JOIN productos prod ON pd.producto_id=prod.id
            WHERE prod.presentacion IN (1,2,6) AND Month(pd.created_at) = Month(NOW())
            GROUP BY prod.descripcion
            ORDER BY total DESC
            LIMIT 20";
            $stockmin = DB::select($query2);
            

            return view('admin.dashboard', compact('stockmin','compras', 'ventas', 'gastos','ganancias','inversion','facturacion','top5_prods'));

        } elseif($user->hasRole('Encargado')){
            
            $date = date_format(date_create(), 'Y-m-d');
            $hoy = date('d');

            $tienda = Usuario_Tienda::Where("user_id",$user->id)->get();

            $ventas   = number_format((float)PedidoMaestro::where('pedidos_maestro.estado', 1)->join('bodegas','pedidos_maestro.bodega_id','=','bodegas.id')->where('bodegas.tienda_id',$tienda[0]->tienda_id)->whereDate('pedidos_maestro.fecha_ingreso', $date)->sum('pedidos_maestro.total'), 2, '.', '');
            $compras  = number_format((float)IngresoMaestro::where('estado_ingreso', 1)->where('user_id',$user->id)->whereDate('fecha_compra', $date)->sum('total_ingreso'), 2, '.', '');
            $gastos   = number_format((float)Gasto::where('estado_id', 1)->where('tienda_id',$tienda[0]->tienda_id)->whereDate('created_at', $date)->sum('monto'), 2, '.', '');


            $query1 = "SELECT prod.descripcion, SUM(pd.cantidad) AS total
            FROM pedidos_detalle pd
            INNER JOIN productos prod ON pd.producto_id=prod.id
            WHERE prod.presentacion IN (1,2,6) AND Month(pd.created_at) = Month(NOW())
            GROUP BY prod.descripcion
            ORDER BY total DESC
            LIMIT 10";
            $top5_prods = DB::select($query1);

            $query2 = "SELECT prod.descripcion, SUM(pd.cantidad) AS total
            FROM pedidos_detalle pd
            INNER JOIN productos prod ON pd.producto_id=prod.id
            WHERE prod.presentacion IN (1,2,6) AND Month(pd.created_at) = Month(NOW())
            GROUP BY prod.descripcion
            ORDER BY total DESC
            LIMIT 20";
            $stockmin = DB::select($query2);
            

            return view('admin.dashboard', compact('compras', 'ventas', 'gastos', 'top5_prods', 'stockmin'));

        }elseif($user->hasRole('Vendedor') ){

            $date = date_format(date_create(), 'Y-m-d');
            $hoy = date('d');

            $tienda = Usuario_Tienda::Where("user_id",$user->id)->get();

            $ventas   = number_format((float)PedidoMaestro::where('pedidos_maestro.estado', 1)->join('bodegas','pedidos_maestro.bodega_id','=','bodegas.id')->where('bodegas.tienda_id',$tienda[0]->tienda_id)->whereDate('pedidos_maestro.fecha_ingreso', $date)->sum('pedidos_maestro.total'), 2, '.', '');
            $gastos   = number_format((float)Gasto::where('estado_id', 1)->where('tienda_id',$tienda[0]->tienda_id)->whereDate('created_at', $date)->sum('monto'), 2, '.', '');
            
            $query1 = "SELECT prod.descripcion, SUM(pd.cantidad) AS total
            FROM pedidos_detalle pd
            INNER JOIN productos prod ON pd.producto_id=prod.id
            WHERE prod.presentacion IN (1,2,6) AND Month(pd.created_at) = Month(NOW())
            GROUP BY prod.descripcion
            ORDER BY total DESC
            LIMIT 10";
            $top5_prods = DB::select($query1);

            $query2 = "SELECT prod.descripcion, SUM(pd.cantidad) AS total
            FROM pedidos_detalle pd
            INNER JOIN productos prod ON pd.producto_id=prod.id
            WHERE prod.presentacion IN (1,2,6) AND Month(pd.created_at) = Month(NOW())
            GROUP BY prod.descripcion
            ORDER BY total DESC
            LIMIT 20";
            $stockmin = DB::select($query2);

            return view('admin.dashboard', compact('stockmin','ventas', 'gastos', 'top5_prods'));
        
        }

    }



    public function getSalesData() {
        $month = date('m');
        $user = Auth::user();

        $tienda = Usuario_Tienda::Where("user_id",$user->id)->get();

        if($user->hasRole('Administrador') || $user->hasRole('Super-Administrador')){

            $data = PedidoMaestro::select(
                'fecha_ingreso as date',
                DB::raw('SUM(total) as amount')
              )->groupBy(
                'fecha_ingreso'
            )->whereRaw('MONTH(fecha_ingreso) = ?', [$month])->get();

        } elseif($user->hasRole('Vendedor')|| $user->hasRole('Encargado')){

            $data = PedidoMaestro::select(
                'pedidos_maestro.fecha_ingreso as date',
                DB::raw('SUM(pedidos_maestro.total) as amount')
            )->join(
                'bodegas',
                'pedidos_maestro.bodega_id',
                '=',
                'bodegas.id'
            )->where(
                'bodegas.tienda_id',
                $tienda[0]->tienda_id
              )->groupBy(
                'pedidos_maestro.fecha_ingreso'
            )->whereRaw('MONTH(pedidos_maestro.fecha_ingreso) = ?', [$month])->get();
        }


        return Response::json($data);
    }




    public function getPurchaseData() {
        $month = date('m');

        $data = IngresoMaestro::select(
            'fecha_compra as date',
            DB::raw('SUM(total_ingreso) as amount')
        )->where(
          'proveedor_id',
          '<>',
          0
          )->where(
            'estado_ingreso',
            '=',
            1)->groupBy(
            'fecha_compra'
        )->whereRaw('MONTH(fecha_compra) = ?', [$month])->get();


        return Response::json($data);
    }

   

}
