<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

use App\Events\ActualizacionBitacora;

use App\Users;
use App\Tienda;
use App\Banco;
use App\Traslados_Bancos;
use App\Saldos_Bancos;


class TrasladosBancosController extends Controller
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
        return view('admin.traslados_bancos.index');
    }


    public function getJson(Request $params){

        $api_Result['data'] = Traslados_Bancos::select(
            'traspasos_banco.id',
            'tiendas.tienda as tienda_origen', 
            'td.tienda as tienda_destino', 
            'bancos.banco', 
            'traspasos_banco.monto',
            'traspasos_banco.created_at',
            'users.name'
        )->join(
            'tiendas', 
            'traspasos_banco.tienda_origen_id', 
            '=', 
            'tiendas.id'
        )->join(
            'tiendas as td', 
            'traspasos_banco.tienda_destino_id', 
            '=', 
            'td.id'
        )->join(
            'bancos', 
            'traspasos_banco.banco_id', 
            '=', 
            'bancos.id'
        )->join(
            'users', 
            'traspasos_banco.user_id', 
            '=', 
            'users.id'
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
        $tiendas = Tienda::all();
        $bancos = Banco::all();

        return view('admin.traslados_bancos.create', compact('tiendas','bancos'));
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
        $tb = Traslados_Bancos::create($data);
        $tb->user_id = Auth::user()->id;
        $tb->save();

        $hoy = Carbon::now();
        $fecha = date_format(date_create($hoy), "Y/m/d");

        $origen = Saldos_Bancos::Where("tienda_id",$request->tienda_origen_id)->Where("banco_id",$request->banco_id)->WhereDate("created_at",$fecha)->get();
        $origen[0]->saldo_real = $origen[0]->saldo_real - $request->monto;
        $origen[0]->saldo_inicial = $origen[0]->saldo_inicial - $request->monto;
        $origen[0]->save();

        $destino = Saldos_Bancos::Where("tienda_id",$request->tienda_destino_id)->Where("banco_id",$request->banco_id)->WhereDate("created_at",$fecha)->get();
        $destino[0]->saldo_real = $destino[0]->saldo_real + $request->monto;
        $destino[0]->saldo_inicial = $destino[0]->saldo_inicial + $request->monto;
        $destino[0]->save();       

        event(new ActualizacionBitacora($tb->id, Auth::user()->id, 'Creacion', '', $tb, 'Traslados Bancos'));

        return redirect()->route('traslados_bancos.index')->withFlash('El traslado se ha registrado exitosamente');
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
    public function destroy(Request $request, Traslados_Bancos $traslados_bancos)
    {
        event(new ActualizacionBitacora($traslados_bancos->id, Auth::user()->id, 'Eliminacion',$traslados_bancos, '', 'Traslados Bancos'));

        $traslados_bancos->delete();

        return Response::json(['success' => 'Exito']);
    }
}
