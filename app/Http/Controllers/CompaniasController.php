<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compania;
use App\Events\ActualizacionBitacora;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;


class CompaniasController extends Controller
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
        return view('admin.companias.index');
    }


    public function getJson(Request $params){

        $api_Result['data'] = Compania::select(
            'companias.id',
            'companias.estado_id', 
            'companias.compania',
            'companias.created_at', 
            'estados.estado'
        )->join(
            'estados', 
            'companias.estado_id', 
            '=', 
            'estados.id'
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
        return view('admin.companias.create');
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
        $compania = Compania::create($data);
        $compania->estado_id = 1;
        $compania->save();

        event(new ActualizacionBitacora($compania->id, Auth::user()->id, 'Creación', '', $compania, 'compañias'));

        return redirect()->route('companias.index')->withFlash('La compañia se ha registrado exitosamente');
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


    public function nombreDisponible(){
        $dato = Input::get("nombre");
        $query = Compania::where("compania",$dato)->where('estado_id', 1)->get();
        $contador = count($query);
        if ($contador == 0 )
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }


    public function edit(Compania $compania)
    {
        return view('admin.companias.edit', compact('compania'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compania $compania)
    {
        $compania->update($request->all());

        event(new ActualizacionBitacora($compania->id, Auth::user()->id, 'Edición', '', $compania, 'compañias'));

        return redirect()->route('companias.index')->withFlash('La compañia se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compania $compania, Request $request)
    {
        $compania->estado_id = 2;
        $compania->save();

        event(new ActualizacionBitacora($compania->id, Auth::user()->id, 'Desactivado', '', '', 'compañias'));

        return Response::json(['success' => 'Éxito']);
    }

    public function activar(Compania $compania, Request $request)
    {
        $compania->estado_id = 1;
        $compania->save();

        event(new ActualizacionBitacora($compania->id, Auth::user()->id, 'Activación', '', '', 'compañias'));

        return Response::json(['success' => 'Éxito']);
    
    }


}
