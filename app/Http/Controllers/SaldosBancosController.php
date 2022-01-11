<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use App\Events\ActualizacionBitacora;

use App\Users;
use App\Tienda;
use App\Banco;
use App\Saldos_Bancos;

class SaldosBancosController extends Controller
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
        return view('admin.saldos_bancos.index');
    }


    public function getJson(Request $params){

        $api_Result['data'] = Saldos_Bancos::select(
            'saldos_bancos.id',
            'tiendas.tienda', 
            'bancos.banco', 
            'saldos_bancos.saldo_inicial',
            'saldos_bancos.saldo_real',
            'saldos_bancos.created_at',
            'users.name'
        )->join(
            'tiendas', 
            'saldos_bancos.tienda_id', 
            '=', 
            'tiendas.id'
        )->join(
            'bancos', 
            'saldos_bancos.banco_id', 
            '=', 
            'bancos.id'
        )->join(
            'users', 
            'saldos_bancos.user_id', 
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

        return view('admin.saldos_bancos.create', compact('tiendas','bancos'));
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
        $sb = Saldos_Bancos::create($data);
        $sb->saldo_real = $request->saldo_inicial;
        $sb->user_id = Auth::user()->id;
        $sb->save();

        event(new ActualizacionBitacora($sb->id, Auth::user()->id, 'Creación', '', $sb, 'Saldos Bancos'));

        return redirect()->route('saldos_bancos.index')->withFlash('El saldo se ha registrado exitosamente');
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
    public function destroy($id)
    {
        //
    }
}
