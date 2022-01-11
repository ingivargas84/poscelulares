<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BodegaMaxMin;
use App\Tienda;
use App\Producto;
use App\Events\ActualizacionBitacora;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class BodegasMaxMinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct(){
        $this->middleware('auth');
    }


    public function index()
    {
        return view('admin.bodegamaxmin.index');
    }

    public function getJson(Request $params){

        $api_Result['data'] = BodegaMaxMin::select(
            'bodegas_maxmin.id',
            'bodegas_maxmin.stock_maximo',
            'bodegas_maxmin.stock_minimo',
            'tiendas.tienda', 
            'productos.descripcion', 
            'bodegas_maxmin.created_at'
        )->join(
            'tiendas', 
            'bodegas_maxmin.tienda_id', 
            '=', 
            'tiendas.id'
        )->join(
            'productos', 
            'bodegas_maxmin.producto_id', 
            '=', 
            'productos.id'
        )->get();

        return Response::json($api_Result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tiendas = Tienda::Where("estado_id","=",1)->get();
        $productos = Producto::Where("estado","=",1)->get();
        
        return view('admin.bodegamaxmin.create', compact('tiendas', 'productos'));
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
        $bodegamaxmin = BodegaMaxMin::create($data);
        $bodegamaxmin->user_id = Auth::user()->id;
        $bodegamaxmin->save();

        event(new ActualizacionBitacora($bodegamaxmin->id, Auth::user()->id, 'Creación', '', $bodegamaxmin, 'Maximos y Minimos'));

        return redirect()->route('bodegamaxmin.index')->withFlash('El registro de máximos y mínimos se ha registrado exitosamente');
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
    public function edit(BodegaMaxMin $bodegamaxmin)
    {
        $tiendas = Tienda::Where("estado_id","=",1)->get();
        $productos = Producto::Where("estado","=",1)->get();
        
        return view('admin.bodegamaxmin.edit', compact('tiendas', 'productos', 'bodegamaxmin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BodegaMaxMin $bodegamaxmin)
    {
        $bodegamaxmin->update($request->all());

        event(new ActualizacionBitacora($bodegamaxmin->id, Auth::user()->id, 'Edición', '', $bodegamaxmin, 'Maximos y Mínimos'));

        return redirect()->route('bodegamaxmin.index')->withFlash('El registro se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BodegaMaxMin $bodegamaxmin)
    {
        event(new ActualizacionBitacora($bodegamaxmin->id, Auth::user()->id, 'Eliminación',$bodegamaxmin, '', 'Maximos y Minimos'));

        $bodegamaxmin->delete();

        return Response::json(['success' => 'Éxito']);
    }


    public function getMaxmin()
    {
        $tienda = Input::get('tienda');
        $producto = Input::get('producto');
        $query = BodegaMaxMin::where('tienda_id','=', $tienda)->where('producto_id','=', $producto)->get();
        $contador = count($query);
        if ($contador == 0) {
            return 'false';
        } else {
            return 'true';
        }
    }



}
