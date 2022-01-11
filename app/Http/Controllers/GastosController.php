<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gasto;
use App\Events\ActualizacionBitacora;
use App\User;
use App\Usuario_Tienda;
use App\RubroGasto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class GastosController extends Controller
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
        return view('admin.gastos.index');
    }


    public function getJson(Request $params){

        $user = Auth::user();
        $query = "SELECT roles.id as id
        FROM users
        INNER JOIN model_has_roles ON users.id = model_id
        INNER JOIN roles ON roles.id = model_has_roles.role_id
        WHERE users.id = $user->id";

        $tienda = Usuario_Tienda::WHERE("user_id",Auth::user()->id)->get();

        $rol= DB::select($query);

        if ($rol[0]->id < 3)
        {

        $api_Result['data'] = Gasto::select(
            'gastos.id',
            'tiendas.tienda', 
            'gastos.descripcion', 
            'gastos.monto',
            'gastos.documento', 
            'rubro_gasto.rubro_gasto',
            'gastos.estado_id',
            'gastos.created_at',
            'users.name'
        )->join(
            'tiendas', 
            'gastos.tienda_id', 
            '=', 
            'tiendas.id'
        )->join(
            'rubro_gasto', 
            'gastos.rubro_gasto_id', 
            '=', 
            'rubro_gasto.id'
        )->join(
            'users', 
            'gastos.user_id', 
            '=', 
            'users.id'
        )->get();

    }
    else
    {
        $api_Result['data'] = Gasto::select(
            'gastos.id',
            'tiendas.tienda', 
            'gastos.descripcion', 
            'gastos.monto',
            'gastos.documento', 
            'rubro_gasto.rubro_gasto',
            'gastos.estado_id',
            'gastos.created_at',
            'users.name'
        )->join(
            'tiendas', 
            'gastos.tienda_id', 
            '=', 
            'tiendas.id'
        )->join(
            'rubro_gasto', 
            'gastos.rubro_gasto_id', 
            '=', 
            'rubro_gasto.id'
        )->join(
            'users', 
            'gastos.user_id', 
            '=', 
            'users.id'
        )->where(
            'gastos.tienda_id', 
            '=', 
            $tienda[0]->tienda_id
        )->get();

    }

        return Response::json($api_Result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $rubro_gasto = RubroGasto::all();

        return view('admin.gastos.create', compact('rubro_gasto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tienda = Usuario_Tienda::Where("user_id",Auth::user()->id)->Where("estado_id",1)->get()->first();

        $data = $request->all();
        $gastos = Gasto::create($data);
        $gastos->estado_id = 1;
        $gastos->user_id = Auth::user()->id;
        $gastos->tienda_id = $tienda->tienda_id;
        $gastos->save();

        event(new ActualizacionBitacora($gastos->id, Auth::user()->id, 'Creación', '', $gastos, 'gastos'));

        return redirect()->route('gastos.index')->withFlash('El gasto se ha registrado exitosamente');
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
    public function edit(Gasto $gasto)
    {
        $rubro_gasto = RubroGasto::all();

        return view('admin.gastos.edit', compact('gasto','rubro_gasto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gasto $gasto)
    {
        $gasto->update($request->all());

        event(new ActualizacionBitacora($gasto->id, Auth::user()->id, 'Edición', '', $gasto, 'Gasto'));

        return redirect()->route('gastos.index')->withFlash('El Gasto se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Gasto $gasto)
    {
        event(new ActualizacionBitacora($gasto->id, Auth::user()->id, 'Eliminación',$gasto, '', 'Gasto'));

        $gasto->delete();

        return Response::json(['success' => 'Éxito']);
    }
}
