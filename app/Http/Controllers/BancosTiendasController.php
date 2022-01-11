<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Banco;
use App\Tienda;
use App\Bancos_Tiendas;
use App\Events\ActualizacionBitacora;
use App\TipoBodega;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class BancosTiendasController extends Controller
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
        return view('admin.bancos_tiendas.index');
    }


    public function getJson(Request $params){

        $api_Result['data'] = Bancos_Tiendas::select(
            'bancos_tiendas.id', 
            'bancos.banco',
            'tiendas.tienda',
            'bancos_tiendas.created_at'
        )->join(
            'bancos', 
            'bancos_tiendas.banco_id', 
            '=', 
            'bancos.id'
        )->join(
            'tiendas', 
            'bancos_tiendas.tienda_id', 
            '=', 
            'tiendas.id'
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

        $bancos = Banco::all();
        $tiendas = Tienda::all();

        return view('admin.bancos_tiendas.create', compact('bancos', 'tiendas'));
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
        $bt = Bancos_Tiendas::create($data);
        $bt->save();

        event(new ActualizacionBitacora($bt->id, Auth::user()->id, 'Creación', '', $bt, 'Bancos Tiendas'));

        return redirect()->route('bancostiendas.index')->withFlash('La asignación se ha registrado exitosamente');
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
    public function edit(Bancos_Tiendas $bancos_tiendas)
    {
        $bancos = Banco::all();
        $tiendas = Tienda::all();

        return view('admin.bancos_tiendas.edit', compact('bancos_tiendas','bancos','tiendas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bancos_Tiendas $bancos_tiendas)
    {
        $bancos_tiendas->update($request->all());

        event(new ActualizacionBitacora($bancos_tiendas->id, Auth::user()->id, 'Edición', '', $bancos_tiendas, 'Bancos a Tiendas'));

        return redirect()->route('bancostiendas.index')->withFlash('La Asignación se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bancos_Tiendas $bancotienda, Request $request)
    {
        $bancotienda->delete();

        event(new ActualizacionBitacora($bancotienda->id, Auth::user()->id, 'Eliminación',$bancotienda , '', 'Banco Tienda'));

        return Response::json(['success' => 'Éxito']);
    }
}
