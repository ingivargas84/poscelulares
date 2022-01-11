<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Marca;
use App\Modelo;
use App\Events\ActualizacionBitacora;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class ModelosController extends Controller
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
        return view('admin.modelos.index');
    }

    public function getJson(Request $params){

        $api_Result['data'] = Modelo::select(
            'modelos.id',
            'modelos.modelo', 
            'marcas.marca', 
            'modelos.estado_id',
            'estados.estado',
            'modelos.created_at'
        )->join(
            'marcas', 
            'modelos.marca_id', 
            '=', 
            'marcas.id'
        )->join(
            'estados', 
            'modelos.estado_id', 
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
        $marcas = Marca::Where("estado_id","=",1)->get();
        
        return view('admin.modelos.create', compact('marcas'));
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
        $modelo = Modelo::create($data);
        $modelo->estado_id = 1;
        $modelo->save();

        event(new ActualizacionBitacora($modelo->id, Auth::user()->id, 'Creación', '', $modelo, 'modelos'));

        return redirect()->route('modelos.index')->withFlash('El modelo se ha registrado exitosamente');
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
    public function edit(Modelo $modelo)
    {
        $marcas = Marca::Where("estado_id","=",1)->get();
        
        return view('admin.modelos.edit', compact('marcas', 'modelo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modelo $modelo)
    {
        $modelo->update($request->all());

        event(new ActualizacionBitacora($modelo->id, Auth::user()->id, 'Edición', '', $modelo, 'modelos'));

        return redirect()->route('modelos.index')->withFlash('El modelo se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modelo $modelo, Request $request)
    {
        $modelo->estado_id = 2;
        $modelo->save();

        event(new ActualizacionBitacora($modelo->id, Auth::user()->id, 'Desactivado', '', '', 'modelos'));

        return Response::json(['success' => 'Éxito']);
    }

    public function activar(Modelo $modelo, Request $request)
    {
        $modelo->estado_id = 1;
        $modelo->save();

        event(new ActualizacionBitacora($modelo->id, Auth::user()->id, 'Activación', '', '', 'modelos'));

        return Response::json(['success' => 'Éxito']);
    
    }

    public function getModelos()
    {
        $modelo = Input::get('modelo');
        $marca = Input::get('marca');
        $query = Modelo::where('modelo','=', $modelo)->where('marca_id','=', $marca)->get();
        $contador = count($query);
        if ($contador == 0) {
            return 'false';
        } else {
            return 'true';
        }
    }
}
