<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\Cliente;
use App\MovimientoProducto;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Visita;
use App\PedidoMaestro;
use App\User;
use App\Tienda;
use App\Proveedor;
use App\TraspasoBodega;
use App\territorios;
use App\Usuario_Tienda;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{


    public function rpt_compras_fecha()
    {        
        return view('admin.reportes.rpt_compras_fecha');
    }

    public function pdf_compras_fecha(Request $request)
    {
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");

        $user = Auth::user();
        $query = "SELECT roles.id as id
        FROM users
        INNER JOIN model_has_roles ON users.id = model_id
        INNER JOIN roles ON roles.id = model_has_roles.role_id
        WHERE users.id = $user->id";

        $rol= DB::select($query);

        if ($rol[0]->id < 3)
        {
            $query ="SELECT pro.nombre_comercial, prod.id AS codigo, prod.descripcion, SUM(ide.cantidad) AS cantidad, ide.precio_compra
            FROM ingresos_maestro im
            INNER JOIN ingresos_detalle ide ON im.id=ide.ingreso_maestro_id
            INNER JOIN proveedores pro ON im.proveedor_id=pro.id
            INNER JOIN productos prod ON ide.producto_id=prod.id
            WHERE im.fecha_factura BETWEEN '". $fecha_inicial ."' AND '". $fecha_final ." '
            GROUP BY pro.nombre_comercial, prod.id, prod.descripcion, ide.precio_compra";
            $data = DB::select($query);
        }
        else
        {
            $query ="SELECT pro.nombre_comercial, prod.id AS codigo, prod.descripcion, SUM(ide.cantidad) AS cantidad, ide.precio_compra
            FROM ingresos_maestro im
            INNER JOIN ingresos_detalle ide ON im.id=ide.ingreso_maestro_id
            INNER JOIN proveedores pro ON im.proveedor_id=pro.id
            INNER JOIN productos prod ON ide.producto_id=prod.id
            WHERE im.user_id = ". Auth::user()->id . " AND im.fecha_factura BETWEEN '". $fecha_inicial ."' AND '". $fecha_final ." '
            GROUP BY pro.nombre_comercial, prod.id, prod.descripcion, ide.precio_compra";
            $data = DB::select($query);
        }

        $usuario = Auth::user()->name;

        $pdf = \PDF::loadView('admin.reportes.pdf_compras_fecha', compact('data','fecha_inicial','fecha_final','usuario'));
        return $pdf->stream('ReporteComprasFecha.pdf');
    }




    public function rpt_traspasos_bodegas()
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
            $usuarios = User::WHERE("estado",1)->WHERE("id",">",5)->get();
            $user =  Auth::user()->id;
        }
        else
        {
            $usuarios = User::WHERE("estado",1)->WHERE("id",Auth::user()->id)->get();
            $user =  Auth::user()->id;
        }       

        return view('admin.reportes.rpt_traspasos_bodegas', compact('usuarios','user'));
    }


    public function pdf_traspasos_bodegas(Request $request)
    {
        $usuario = $request->user_id;
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");

        if ($usuario == "default")
        {
            $query ="SELECT DATE(tb.created_at) As fecha, bod1.nombre AS origen, bod2.nombre AS destino, us.name AS usuario, prod.descripcion, td.cantidad, td.imei
            FROM traspasos_bodega tb
            INNER JOIN traspasos_detalle td ON tb.id=td.traspasos_bodega_id
            INNER JOIN bodegas bod1 ON tb.bodega_origen=bod1.id
            INNER JOIN bodegas bod2 ON tb.bodega_destino=bod2.id
            INNER JOIN users us ON tb.user_id=us.id
            INNER JOIN productos prod ON td.producto_id=prod.id
            WHERE DATE(tb.created_at) BETWEEN '". $fecha_inicial ."' AND '". $fecha_final ."'
            ORDER BY DATE(tb.created_at) DESC";
            $data = DB::select($query);
        }
        else
        {
            $query ="SELECT DATE(tb.created_at) As fecha, bod1.nombre AS origen, bod2.nombre AS destino, us.name AS usuario, prod.descripcion, td.cantidad, td.imei
            FROM traspasos_bodega tb
            INNER JOIN traspasos_detalle td ON tb.id=td.traspasos_bodega_id
            INNER JOIN bodegas bod1 ON tb.bodega_origen=bod1.id
            INNER JOIN bodegas bod2 ON tb.bodega_destino=bod2.id
            INNER JOIN users us ON tb.user_id=us.id
            INNER JOIN productos prod ON td.producto_id=prod.id
            WHERE tb.user_id = " . $usuario . " AND DATE(tb.created_at) BETWEEN '". $fecha_inicial ."' AND '". $fecha_final ."'
            ORDER BY DATE(tb.created_at) ASC";
            $data = DB::select($query);

        }
        
        
        $pdf = \PDF::loadView('admin.reportes.pdf_traspasos_bodegas', compact('data','fecha_inicial','fecha_final'));
        return $pdf->stream('ReporteTraspasosBodegas.pdf');
    }



    public function rpt_ventas_imei()
    {        
        $productos = Producto::WHERE("estado",1)->get();

        return view('admin.reportes.rpt_ventas_imei', compact('productos'));
    }

    public function pdf_ventas_imei(Request $request)
    {

        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");
        $producto = $request->producto_id;

        $query ="SELECT pd.imei, DATE(pd.created_at) AS fecha, td.tienda, us.name
        FROM pedidos_detalle pd
        INNER JOIN pedidos_maestro pm ON pm.id = pd.pedido_maestro_id
        INNER JOIN bodegas bod ON bod.id = pm.bodega_id
        INNER JOIN tiendas td ON td.id = bod.tienda_id
        INNER JOIN users us ON pm.user_id = us.id
        WHERE pd.producto_id = " . $producto . " AND ( DATE(pd.created_at) BETWEEN '" . $fecha_inicial . "' AND '" . $fecha_final . "') 
        ORDER BY pd.created_at DESC, td.tienda ASC, pd.imei ASC";
        $data = DB::select($query);

        $query2 ="SELECT COUNT(pd.imei) as total_vendido
        FROM pedidos_detalle pd
        WHERE pd.producto_id = " . $producto . " AND ( DATE(pd.created_at) BETWEEN '" . $fecha_inicial . "' AND '" . $fecha_final . "')";
        $total_vendidos = DB::select($query2);

        $query2 ="SELECT SUM(pd.cantidad) as total_vendidos, SUM(pd.subtotal) as total_quetzales
        FROM pedidos_detalle pd
        WHERE pd.producto_id = " . $producto . " AND ( DATE(pd.created_at) BETWEEN '" . $fecha_inicial . "' AND '" . $fecha_final . "')";
        $total_vendidos = DB::select($query2);

        $query3 ="SELECT SUM(pm.descuento_porcentaje + pm.descuento_valores) as descuentos
        FROM pedidos_detalle pd
        INNER JOIN pedidos_maestro pm ON pm.id=pd.pedido_maestro_id
        WHERE pd.producto_id = " . $producto . " AND ( DATE(pd.created_at) BETWEEN '" . $fecha_inicial . "' AND '" . $fecha_final . "')";
        $total_descuentos = DB::select($query3);

        $query3 ="SELECT * FROM productos WHERE id = " . $producto . "";
        $telefono = DB::select($query3);


        $pdf = \PDF::loadView('admin.reportes.pdf_ventas_imei', compact('data', 'producto', 'fecha_inicial', 'fecha_final','total_vendidos', 'telefono', 'total_descuentos'));
        return $pdf->stream('ReporteImeiProductosFecha.pdf');
    }



    public function rpt_listado_imei()
    {        
        $productos = Producto::WHERE("estado",1)->get();

        return view('admin.reportes.rpt_listado_imei', compact('productos'));
    }

  

    public function pdf_listado_imei(Request $request)
    {
        $producto = $request->producto_id;

        $prods = Producto::Where("id",$request->producto_id)->get();

        $user = Auth::user()->name;
        $fecha = Carbon::now();

        $query ="SELECT pim.id, pim.imei, bod.nombre as bodega
        FROM productos_imei pim
        INNER JOIN bodegas bod ON pim.bodega_id=bod.id
        WHERE pim.producto_id = " . $producto . " AND pim.estado_venta_id = 1
        ORDER BY bod.nombre ASC, pim.imei ASC";

        $data = DB::select($query);


        $query2 ="SELECT producto_id, COUNT(imei) as total
        FROM productos_imei
        WHERE producto_id = " . $producto . " AND estado_venta_id = 1
        GROUP BY producto_id";

        $total = DB::select($query2);


        $pdf = \PDF::loadView('admin.reportes.pdf_listado_imeis', compact('producto','data','total', 'prods','user','fecha'));
        return $pdf->stream('ReporteListadoImei.pdf');

    }



    public function rpt_listado_gastos_fecha()
    {        
        $tiendas = Tienda::all();

        return view('admin.reportes.rpt_listado_gastos_fecha', compact('tiendas'));
    }

    public function pdf_listado_gastos_fecha(Request $request)
    {
        $tienda = $request->tienda_id;
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");



        if ($tienda !== "default")
        {
            $tiendas = Tienda::Where("id",$request->tienda_id)->get();

            $query ="SELECT rg.rubro_gasto, gas.descripcion, gas.documento, gas.monto, gas.created_at, us.username
            FROM gastos gas
            INNER JOIN rubro_gasto rg ON gas.rubro_gasto_id=rg.id
            INNER JOIN users us ON gas.user_id=us.id
            WHERE gas.tienda_id = " . $tienda . " AND DATE(gas.created_at) BETWEEN '". $fecha_inicial ."' AND '". $fecha_final ."'
            ORDER BY gas.created_at DESC, gas.id ASC";
            $data = DB::select($query);


            $query2 ="SELECT SUM(monto) as total
            FROM gastos
            WHERE tienda_id = " . $tienda . " AND DATE(created_at)  BETWEEN '". $fecha_inicial ."' AND '". $fecha_final ."'";

            $total = DB::select($query2);

        }
        else
        {
            $tiendas = Tienda::Where("id",$request->tienda_id)->get();
            
            $query ="SELECT rg.rubro_gasto, gas.descripcion, gas.documento, gas.monto, gas.created_at, us.username
            FROM gastos gas
            INNER JOIN rubro_gasto rg ON gas.rubro_gasto_id=rg.id
            INNER JOIN users us ON gas.user_id=us.id
            WHERE DATE(gas.created_at) BETWEEN '". $fecha_inicial ."' AND '". $fecha_final ."'
            ORDER BY gas.created_at DESC, gas.id ASC";
            $data = DB::select($query);


            $query2 ="SELECT SUM(monto) as total
            FROM gastos
            WHERE DATE(created_at)  BETWEEN '". $fecha_inicial ."' AND '". $fecha_final ."'";
            $total = DB::select($query2);

        }      

        $pdf = \PDF::loadView('admin.reportes.pdf_listado_gastos_fecha', compact('tienda','tiendas','data','total', 'fecha_inicial','fecha_final'));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('ReporteDetalleGastosporFecha.pdf');

    }


    public function rpt_ventas_fecha_tienda()
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
            $usuarios = User::WHERE("estado",1)->WHERE("id",">",5)->get();
            $user =  Auth::user()->id;
            $tiendas = Tienda::all();
        }
        else
        {
            $usuarios = User::WHERE("estado",1)->WHERE("id",Auth::user()->id)->get();
            $user =  Auth::user()->id;
            $usuario_tienda = Usuario_Tienda::WHERE("user_id",$user)->get();
            $tiendas = Tienda::WHERE("id",$usuario_tienda[0]->tienda_id)->get();
        }       

        return view('admin.reportes.rpt_ventas_fecha_tienda', compact('tiendas','rol'));
    }


    public function pdf_ventas_fecha_tienda(Request $request)
    {
        $tienda = $request->tienda_id;
        $fecha = date_format(date_create($request->fecha), "Y/m/d");

        if ($tienda !== "default")
        {
            $tiendas = Tienda::Where("id",$request->tienda_id)->get();

            $query ="SELECT pd.cantidad, pd.precio, pd.subtotal, pro.descripcion, pd.imei, us.username
            FROM pedidos_detalle pd
            INNER JOIN productos pro ON pd.producto_id=pro.id
            INNER JOIN pedidos_maestro pm ON pd.pedido_maestro_id=pm.id
            INNER JOIN bodegas bod ON pm.bodega_id=bod.id
            INNER JOIN users us ON pm.user_id=us.id
            WHERE bod.tienda_id = " . $tienda . " AND DATE(pd.created_at) = '". $fecha ."'
            ORDER BY pd.id ASC";
            $data = DB::select($query);

            $query2 ="SELECT SUM(pd.subtotal) as total
            FROM pedidos_detalle pd
            INNER JOIN pedidos_maestro pm ON pd.pedido_maestro_id=pm.id
            INNER JOIN bodegas bod ON pm.bodega_id=bod.id
            WHERE bod.tienda_id = " . $tienda . " AND DATE(pd.created_at) = '". $fecha ."'";
            $total = DB::select($query2);

            $query3 ="SELECT SUM(pm.descuento_porcentaje) + SUM(pm.descuento_valores) as descuentos
            FROM pedidos_maestro pm
            INNER JOIN bodegas bod ON pm.bodega_id=bod.id
            WHERE bod.tienda_id = " . $tienda . " AND DATE(pm.created_at) = '". $fecha ."'";
            $descuentos = DB::select($query3);

        }
        else
        {
            $tiendas = Tienda::Where("id",$request->tienda_id)->get();

            $query ="SELECT pd.cantidad, pd.precio, pd.subtotal, pro.descripcion, pd.imei, us.name
            FROM pedidos_detalle pd
            INNER JOIN productos pro ON pd.producto_id=pro.id
            INNER JOIN pedidos_maestro pm ON pd.pedido_maestro_id=pm.id
            INNER JOIN users us ON pm.user_id=us.id
            WHERE DATE(pd.created_at) = '". $fecha ."'
            ORDER BY pd.id ASC";
            $data = DB::select($query);

            $query2 ="SELECT SUM(pd.subtotal) as total
            FROM pedidos_detalle pd
            INNER JOIN pedidos_maestro pm ON pd.pedido_maestro_id=pm.id
            WHERE DATE(pd.created_at) = '". $fecha ."'";
            $total = DB::select($query2);

            $query3 ="SELECT SUM(pm.descuento_porcentaje) + SUM(pm.descuento_valores) as descuentos
            FROM pedidos_maestro pm
            INNER JOIN bodegas bod ON pm.bodega_id=bod.id
            WHERE  DATE(pm.created_at) = '". $fecha ."'";
            $descuentos = DB::select($query3);

        }

        
        $pdf = \PDF::loadView('admin.reportes.pdf_ventas_fecha_tienda', compact('descuentos','tiendas','data','total', 'fecha','tienda'));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('ReporteDetalleGastosporFecha.pdf');

    }



    public function rpt_corte_caja()
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
            $usuarios = User::WHERE("estado",1)->WHERE("id",">",5)->get();
            $user =  Auth::user()->id;
            $tiendas = Tienda::all();
        }
        else
        {
            $usuarios = User::WHERE("estado",1)->WHERE("id",Auth::user()->id)->get();
            $user =  Auth::user()->id;
            $usuario_tienda = Usuario_Tienda::WHERE("user_id",$user)->get();
            $tiendas = Tienda::WHERE("id",$usuario_tienda[0]->tienda_id)->get();
        }       

        return view('admin.reportes.rpt_corte_caja', compact('tiendas','rol'));
    }


    public function pdf_corte_caja(Request $request)
    {
        $tienda = $request->tienda_id;
        $fecha = date_format(date_create($request->fecha), "Y/m/d");

        $tiendas = Tienda::Where("id",$request->tienda_id)->get();

        $query ="SELECT SUM(monto) as total
        FROM gastos
        WHERE tienda_id = " . $tienda . " AND DATE(created_at) = '". $fecha ."'";

        $total_gastos = DB::select($query);


        $query2 ="SELECT SUM(pd.subtotal) as total
        FROM pedidos_detalle pd
        INNER JOIN pedidos_maestro pm ON pd.pedido_maestro_id=pm.id
        INNER JOIN bodegas bod ON pm.bodega_id=bod.id
        WHERE bod.tienda_id = " . $tienda . " AND DATE(pd.created_at) = '". $fecha ."'";
        $total_venta = DB::select($query2);

        $saldo_caja = $total_venta[0]->total - $total_gastos[0]->total;


        $pdf = \PDF::loadView('admin.reportes.pdf_corte_caja', compact('tiendas','total_gastos','total_venta', 'fecha','saldo_caja'));
        return $pdf->stream('ReporteCorteCaja.pdf');

    }


    public function rpt_ventas_totales_tienda()
    {        

        return view('admin.reportes.rpt_ventas_totales_tienda');
    }


    public function pdf_ventas_totales_tienda(Request $request)
    {
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");

        $query ="SELECT td.tienda, SUM(pm.subtotal) as total
        FROM pedidos_maestro pm
        INNER JOIN bodegas bod ON pm.bodega_id=bod.id
        INNER JOIN tiendas td ON bod.tienda_id=td.id
        WHERE DATE(pm.created_at) BETWEEN '". $fecha_inicial ."' AND '" . $fecha_final ."'
        GROUP BY td.tienda
        ORDER BY td.tienda ASC";
        $data = DB::select($query);


        $query2 ="SELECT SUM(subtotal) as total
        FROM pedidos_maestro
        WHERE DATE(created_at) BETWEEN '". $fecha_inicial ."' AND '" . $fecha_final ."'";

        $total = DB::select($query2);

        $query_tienda="SELECT td.tienda, pro.descripcion, MAX(pd.cantidad) as cantidad
        FROM pedidos_maestro pm
            INNER JOIN 
            (SELECT pedido_maestro_id, producto_id, SUM(cantidad) AS cantidad
            FROM pedidos_detalle
            GROUP BY pedido_maestro_id, producto_id
            ) pd ON pm.id=pd.pedido_maestro_id
           INNER JOIN productos pro ON pro.id = pd.producto_id
           INNER JOIN bodegas bod ON pm.bodega_id=bod.id
           INNER JOIN tiendas td ON bod.tienda_id=td.id
           WHERE DATE(pm.created_at) BETWEEN '". $fecha_inicial ."' AND '" . $fecha_final ."' AND pro.presentacion IN (1,2,6)
           GROUP BY td.tienda
           ORDER BY td.tienda ASC";
        $productos_tienda = DB::select($query_tienda);

        
        $query_vend = "SELECT td.tienda, us.name, MAX(pd.cantidad) AS uni_vendidas
        FROM pedidos_maestro pm
        INNER JOIN 
		  (SELECT pedido_maestro_id, producto_id, SUM(cantidad) AS cantidad
		    FROM pedidos_detalle
	    GROUP BY pedido_maestro_id, producto_id
	    ) pd ON pd.pedido_maestro_id=pm.id
        INNER JOIN productos pro ON pd.producto_id=pro.id
        INNER JOIN users us ON pm.user_id=us.id
        INNER JOIN bodegas bod ON pm.bodega_id=bod.id
        INNER JOIN tiendas td ON bod.tienda_id=td.id
        WHERE DATE(pm.created_at) BETWEEN '". $fecha_inicial ."' AND '" . $fecha_final ."' AND pro.presentacion IN (1,2,3,4,5,6,8)
        GROUP BY td.tienda
        ORDER BY uni_vendidas DESC";
        $usuarios_ventas = DB::select($query_vend);


        $pdf = \PDF::loadView('admin.reportes.pdf_ventas_totales_tienda', compact('data', 'fecha_inicial', 'fecha_final', 'total', 'productos_tienda', 'usuarios_ventas'));
        return $pdf->stream('ReporteVentasTotalesTienda.pdf');

    }


    public function rpt_precio_compra_producto()
    {        
        $productos = Producto::WHERE("estado",1)->get();

        return view('admin.reportes.rpt_precio_compra_producto', compact('productos'));
    }

  

    public function pdf_precio_compra_producto(Request $request)
    {
        $producto = $request->producto_id;

        $prods = Producto::Where("id",$request->producto_id)->get();

        $query ="SELECT im.fecha_factura, id.precio_compra, prov.nombre_comercial
        FROM ingresos_detalle id
        INNER JOIN ingresos_maestro im ON im.id=id.ingreso_maestro_id
        INNER JOIN proveedores prov ON im.proveedor_id = prov.id
        WHERE id.producto_id = " . $producto ."
        GROUP BY id.precio_compra, prov.nombre_comercial, im.fecha_factura
        ORDER BY im.fecha_factura DESC";
        $data = DB::select($query);

        $query2 = "SELECT precio_compra, COUNT(*) as cantidad
        FROM ingresos_detalle
        WHERE producto_id = " . $producto ."
        GROUP BY precio_compra
        LIMIT 1";
        $precio_mayor = DB::select($query2);

        $query3 = "SELECT fecha_ingreso, precio_compra
        FROM ingresos_detalle
        WHERE producto_id = " . $producto . " AND precio_compra = " . $precio_mayor[0]->precio_compra . "
        GROUP BY precio_compra, fecha_ingreso
        ORDER BY fecha_ingreso DESC";
        $fecha_mayor = DB::select($query3);

        $pdf = \PDF::loadView('admin.reportes.pdf_precio_compra_producto', compact('producto','data', 'prods', 'precio_mayor', 'fecha_mayor'));
        return $pdf->stream('ReportePrecioCompraProducto.pdf');

    }


    public function rpt_inventario_general_costos()
    {        
        $tiendas = Tienda::all();

        return view('admin.reportes.rpt_inventario_general_costos', compact('tiendas'));
    }

  

    public function pdf_inventario_general_costos(Request $request)
    {
        $hoy = Carbon::now();
        $fecha = date_format(date_create($hoy), "Y/m/d H:m:s");

        $usuario = Auth::user()->name;
        $tienda = $request->tienda_id;
        $tiendas = Tienda::Where("id",$request->tienda_id)->get();

        if ($tienda == "default")
        {
            $query ="SELECT prod.id, prod.descripcion, SUM(mp.existencias) AS existencias, 
            (SELECT AVG(precio_compra)
            FROM ingresos_detalle
            WHERE producto_id = prod.id ) AS precio
        
            FROM productos prod
            INNER JOIN movimientos_producto mp ON mp.producto_id=prod.id
            GROUP BY prod.id, prod.descripcion
            HAVING SUM(mp.existencias) > 0
            ORDER BY prod.id ASC";

            $data = DB::select($query);

        }
        else
        {
            $query ="SELECT prod.id, prod.descripcion, SUM(mp.existencias) AS existencias, 
            (SELECT AVG(precio_compra)
            FROM ingresos_detalle
            WHERE producto_id = prod.id ) AS precio
        
            FROM productos prod
            INNER JOIN movimientos_producto mp ON mp.producto_id=prod.id
            INNER JOIN bodegas bod ON mp.bodega_id = bod.id
			WHERE bod.tienda_id = " . $tienda . "
            GROUP BY prod.id, prod.descripcion
            HAVING SUM(mp.existencias) > 0
            ORDER BY prod.id ASC";

            $data = DB::select($query);

        }

        
        $pdf = \PDF::loadView('admin.reportes.pdf_inventario_general_costos', compact('fecha','data','usuario','tiendas','tienda'));
        return $pdf->stream('ReporteInventarioGeneralCostos.pdf');

    }


    public function rpt_ventas_usuario()
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
            $usuarios = User::WHERE("estado",1)->WHERE("id",">",5)->get();
        }
        else
        {
            $usuarios = User::WHERE("estado",1)->WHERE("id",Auth::user()->id)->get();
        }       
        
        return view('admin.reportes.rpt_ventas_usuario', compact('usuarios'));
    }

  

    public function pdf_ventas_usuario(Request $request)
    {
        $usuario = $request->user_id;
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");
        $usuarios = User::WHERE("id",$request->user_id)->get();
        
        $query ="SELECT pm.fecha_ingreso, prod.id, pd.cantidad, prod.descripcion, pd.imei
        FROM pedidos_maestro pm
        INNER JOIN pedidos_detalle pd ON pm.id=pd.pedido_maestro_id
        INNER JOIN productos prod ON pd.producto_id=prod.id
        WHERE pm.user_id = " . $usuario . " AND pm.fecha_ingreso BETWEEN '". $fecha_inicial ."' AND '" . $fecha_final ."'
        ORDER BY pm.fecha_ingreso DESC";
        $data = DB::select($query);

        $query2 ="SELECT com.compania, COUNT(*) as total
        FROM pedidos_maestro pm
        INNER JOIN pedidos_detalle pd ON pm.id=pd.pedido_maestro_id
        INNER JOIN productos prod ON pd.producto_id=prod.id
        INNER JOIN companias com ON com.id=prod.compania_id
        WHERE pm.user_id = " . $usuario . " AND pm.fecha_ingreso BETWEEN '". $fecha_inicial ."' AND '" . $fecha_final ."' AND prod.presentacion in (1,2,6)
        GROUP BY com.compania";
        $resumen = DB::select($query2);

        $pdf = \PDF::loadView('admin.reportes.pdf_ventas_usuario', compact('usuarios','data', 'fecha_inicial', 'fecha_final', 'resumen'));
        return $pdf->stream('ReporteVentasUsuario.pdf');

    }




    public function rpt_movimientos_productos()
    {                
        return view('admin.reportes.rpt_movimientos_productos');
    }

  

    public function pdf_movimientos_productos(Request $request)
    {
        $imei = $request->imei;
        
        $query ="SELECT prod.id as codigo, prod.descripcion, prod.precio_venta, pim.estado_venta_id, bod.nombre as bodega, 
        im.fecha_factura, im.serie_factura, im.num_factura, ide.precio_compra, prov.nombre_comercial, us.name, ev.estado_venta
        FROM productos_imei pim
        INNER JOIN productos prod ON pim.producto_id=prod.id
        INNER JOIN bodegas bod ON pim.bodega_id=bod.id
        INNER JOIN ingresos_detalle ide ON ide.id=pim.ingreso_detalle_id
        INNER JOIN ingresos_maestro im ON ide.ingreso_maestro_id=im.id
        INNER JOIN estado_venta ev ON ev.id=pim.estado_venta_id
        INNER JOIN proveedores prov ON im.proveedor_id=prov.id
        INNER JOIN users us ON im.user_id= us.id
        WHERE pim.imei = '" . $imei . "'";
        $compra_imei = DB::select($query);

        $query2="SELECT DATE(tb.created_at) AS fecha_traslado, bod1.nombre AS origen, bod2.nombre AS destino, us.name
        FROM traspasos_detalle td 
        INNER JOIN traspasos_bodega tb ON tb.id=td.traspasos_bodega_id
        INNER JOIN bodegas bod1 ON bod1.id=tb.bodega_origen
        INNER JOIN bodegas bod2 ON bod2.id=tb.bodega_destino
        INNER JOIN users us ON us.id=tb.user_id
        WHERE td.imei = '" . $imei . "'";
        $traslado_imei = DB::select($query2);

        $query3="SELECT pm.fecha_ingreso AS fecha_venta, us.name, vc.nit, vc.nombre AS cliente, 
        pm.no_pedido, pd.precio AS precio_venta
        FROM pedidos_detalle pd
        INNER JOIN pedidos_maestro pm ON pm.id=pd.pedido_maestro_id
        INNER JOIN users us ON pm.user_id=us.id
        INNER JOIN ventas_clientes vc ON vc.pedido_maestro_id=pm.id
        WHERE pd.imei = '" . $imei . "'";
        $venta_imei = DB::select($query3);

       
        $pdf = \PDF::loadView('admin.reportes.pdf_movimientos_productos', compact('imei','compra_imei','traslado_imei','venta_imei'));
        return $pdf->stream('ReporteMovimientosProductos.pdf');

    }




    public function rpt_movimientos_bancarios()
    {                
        $usuarios = User::WHERE("estado",1)->WHERE("id",">",5)->get();
        $tiendas = Tienda::all();
        
        return view('admin.reportes.rpt_movimientos_bancarios', compact('usuarios','tiendas'));
    }

  

    public function pdf_movimientos_bancarios(Request $request)
    {
        $usuario = $request->user_id;
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");
        $tienda = $request->tienda_id;

        $usuarios = User::WHERE("id",$request->user_id)->get();
        $tiendas = Tienda::Where("id",$request->tienda_id)->get();

        if ($usuario == "default" && $tienda == "default")
        {
            $query ="SELECT DATE(tb.created_at) AS fecha_transaccion, td.tienda, ban.banco, us.name, tt.tipo_transaccion, tb.monto_favor,
            tb.monto_total
            FROM transaccion_bancaria tb
            INNER JOIN tiendas td ON td.id=tb.tienda_id
            INNER JOIN bancos ban ON tb.banco_id=ban.id
            INNER JOIN users us ON tb.user_id=us.id
            INNER JOIN tipo_transaccion tt ON tt.id=tb.tipo_transaccion_id
            WHERE DATE(tb.created_at) BETWEEN '". $fecha_inicial ."' AND '" . $fecha_final ."'
            ORDER BY td.tienda ASC, ban.banco ASC, fecha_transaccion DESC";
            $trans_bancos = DB::select($query);

        }

               
        $pdf = \PDF::loadView('admin.reportes.pdf_movimientos_bancarios', compact('usuario','fecha_inicial','fecha_final','tienda','trans_bancos','usuarios','tiendas'));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('ReporteMovimientosBancarios.pdf');

    }




    public function rpt_proyecciones()
    {                
        return view('admin.reportes.rpt_proyecciones');
    }

  

    public function pdf_proyecciones(Request $request)
    {
        $tipo_proyeccion = $request->proyeccion;
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");

               
        $pdf = \PDF::loadView('admin.reportes.pdf_proyecciones', compact('tipo_proyeccion','fecha_inicial'));
        return $pdf->stream('ReporteProyecciones.pdf');

    }




}
