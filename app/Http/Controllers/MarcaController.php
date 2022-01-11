<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;
use App\Events\ActualizacionBitacora;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
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
        return view('admin.marcas.index');
    }


    public function getJson(Request $params){

        $api_Result['data'] = Marca::select(
            'marcas.id',
            'marcas.marca', 
            'marcas.created_at', 
            'marcas.estado_id',
            'estados.estado', 
            'users.name'
        )->join(
            'estados', 
            'marcas.estado_id', 
            '=', 
            'estados.id'
        )->join(
            'users', 
            'marcas.user_id', 
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
        return view('admin.marcas.create');
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
        $marca = Marca::create($data);
        $marca->user_id = Auth::user()->id;
        $marca->estado_id = 1;
        $marca->save();

        event(new ActualizacionBitacora($marca->id, Auth::user()->id, 'Creación', '', $marca, 'marcas'));

        return redirect()->route('marcas.index')->withFlash('La marca se ha registrado exitosamente');
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
    public function edit(Marca $marca)
    {
        return view('admin.marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Marca $marca, Request $request)
    {
        $marca->update($request->all());

        event(new ActualizacionBitacora($marca->id, Auth::user()->id, 'Edición', '', $marca, 'marcas'));

        return redirect()->route('marcas.index')->withFlash('La marca se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca, Request $request)
    {
        $marca->estado_id = 2;
        $marca->save();

        event(new ActualizacionBitacora($marca->id, Auth::user()->id, 'Desactivado', '', '', 'marcas'));

        return Response::json(['success' => 'Éxito']);
    }

    public function activar(Marca $marca, Request $request)
    {
        $marca->estado_id = 1;
        $marca->save();

        event(new ActualizacionBitacora($marca->id, Auth::user()->id, 'Activación', '', '', 'marcas'));

        return Response::json(['success' => 'Éxito']);
    
    }


    public function marcaDisponible()
    {
        $dato = Input::get('marca');
        $query = Marca::where('marca','=',$dato)->get();
        $contador = count($query);
        if ($contador == 0) {
            return 'false';
        } else {
            return 'true';
        }
    }


}
