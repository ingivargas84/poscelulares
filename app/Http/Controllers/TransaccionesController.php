<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Banco;
use App\Tienda;
use App\TipoTransaccion;
use App\TransaccionBancaria;
use App\User;
use App\Saldos_Bancos;

use App\Events\ActualizacionBitacora;


class TransaccionesController extends Controller
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
        return view('admin.transacciones.index');
    }


    public function getJson(Request $params){

        $api_Result['data'] = TransaccionBancaria::select(
            'transaccion_bancaria.id', 
            'bancos.banco',
            'tiendas.tienda',
            'users.name',
            'tipo_transaccion.tipo_transaccion',
            'transaccion_bancaria.monto_total',
            'transaccion_bancaria.created_at'
        )->join(
            'bancos', 
            'transaccion_bancaria.banco_id', 
            '=', 
            'bancos.id'
        )->join(
            'tiendas', 
            'transaccion_bancaria.tienda_id', 
            '=', 
            'tiendas.id'
        )->join(
            'users', 
            'transaccion_bancaria.user_id', 
            '=', 
            'users.id'
        )->join(
            'tipo_transaccion', 
            'transaccion_bancaria.tipo_transaccion_id', 
            '=', 
            'tipo_transaccion.id'
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
        $tienda = Tienda::all();
        $banco = Banco::all();
        $tipo_transaccion = TipoTransaccion::all();

        return view('admin.transacciones.create', compact('tienda','banco','tipo_transaccion'));
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
        $tx = TransaccionBancaria::create($data);
        $tx->user_id = Auth::user()->id;
        $tx->movimiento = "X";
        $tx->save();

        $hoy = Carbon::now();
        $fecha = date_format(date_create($hoy), "Y/m/d");

        if ($request->tipo_transaccion_id == 1)
        {
            $saldo = Saldos_Bancos::Where("tienda_id",$request->tienda_id)->Where("banco_id",$request->banco_id)->WhereDate("created_at",$fecha)->get();
            $saldo[0]->saldo_real = $saldo[0]->saldo_real + $request->monto_total;
            $saldo[0]->saldo_inicial = $saldo[0]->saldo_inicial - $request->monto_total;
            $saldo[0]->save();
        }
        else if ($request->tipo_transaccion_id == 2)
        {
            $saldo = Saldos_Bancos::Where("tienda_id",$request->tienda_id)->Where("banco_id",$request->banco_id)->WhereDate("created_at",$fecha)->get();
            $saldo[0]->saldo_real = $saldo[0]->saldo_real + $request->monto_total;
            $saldo[0]->saldo_inicial = $saldo[0]->saldo_inicial - $request->monto_total;
            $saldo[0]->save();
        }
        else if ($request->tipo_transaccion_id == 3)
        {
            $saldo = Saldos_Bancos::Where("tienda_id",$request->tienda_id)->Where("banco_id",$request->banco_id)->WhereDate("created_at",$fecha)->get();
            $saldo[0]->saldo_real = $saldo[0]->saldo_real - $request->monto_total;
            $saldo[0]->saldo_inicial = $saldo[0]->saldo_inicial + $request->monto_total;
            $saldo[0]->save();
        }
        else if ($request->tipo_transaccion_id == 4)
        {
            $saldo = Saldos_Bancos::Where("tienda_id",$request->tienda_id)->Where("banco_id",$request->banco_id)->WhereDate("created_at",$fecha)->get();
            $saldo[0]->saldo_real = $saldo[0]->saldo_real - $request->monto_total;
            $saldo[0]->saldo_inicial = $saldo[0]->saldo_inicial + $request->monto_total;
            $saldo[0]->save();
        }

        event(new ActualizacionBitacora($tx->id, Auth::user()->id, 'Creacion', '', $tx, 'Transacciones'));

        return redirect()->route('transacciones.index')->withFlash('La Transaccion se ha registrado exitosamente');
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
    public function destroy(TransaccionBancaria $transaccion, Request $request)
    {
        $transaccion->delete();

        event(new ActualizacionBitacora($transaccion->id, Auth::user()->id, 'Eliminacion',$transaccion , '', 'Transaccion'));

        return Response::json(['success' => 'Exito']);
    }
}
