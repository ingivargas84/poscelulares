<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\Events\ActualizacionBitacora;
use App\TipoBodega;
use App\Tienda;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class BodegasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.bodegas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = TipoBodega::all();
        $tiendas = Tienda::all();

        return view('admin.bodegas.create', compact('tipos', 'tiendas'));
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
        $bodega = Bodega::create($data);
        $bodega->estado = 1;
        $bodega->user_id = Auth::user()->id;
        $bodega->save();

        event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Creación', '', $bodega, 'bodegas'));

        return redirect()->route('bodegas.index')->withFlash('La bodega se ha registrado exitosamente');
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
    public function edit(Bodega $bodega, Request $request)
    {
        $tipos = TipoBodega::all();
        $tiendas = Tienda::all();
        
        return view('admin.bodegas.edit', compact('tipos', 'tiendas', 'bodega'));
    }

 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bodega $bodega)
    {
        $bodega->update($request->all());

        event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Edición', '', $bodega, 'bodegas'));

        return redirect()->route('bodegas.index')->withFlash('La bodega se ha modificado exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bodega $bodega, Request $request)
    {
        $bodega->estado = 2;
        $bodega->save();

        event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Inactivación', '', '', 'bodegas'));

        return Response::json(['success'=> 'Éxito']);
    }

    public function activar(Bodega $bodega, Request $request)
    {
          $bodega->estado = 1;
          $bodega->save();
       
          event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Activación', '', '', 'bodegas'));

          return Response::json(['success'=> 'Éxito']);
     }

   

    public function getJson(Request $params){
        $api_Result['data'] = Bodega::select(
            'bodegas.nombre', 
            'bodegas.descripcion',
            'tipos_bodega.tipo', 
            'bodegas.estado',
            'bodegas.id', 
            'tiendas.tienda',
            'users.name as encargado'
        )->join(
            'tipos_bodega', 
            'bodegas.tipo', 
            '=', 
            'tipos_bodega.id'
        )->join(
            'tiendas', 
            'bodegas.tienda_id', 
            '=', 
            'tiendas.id'
        )->join(
          'users', 
          'bodegas.user_id', 
          '=', 
          'users.id'
        )->get();

        return Response::json($api_Result);
    }
}

