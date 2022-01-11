<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Banco;
use App\Events\ActualizacionBitacora;
use App\TipoBodega;
use App\Tienda;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class BancosController extends Controller
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
        return view('admin.bancos.index');
    }


    public function getJson(Request $params)
     {
         $api_Result['data'] = Banco::all(); 

         return Response::json( $api_Result );
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bancos.create');
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
        $banco = Banco::create($data);
        $banco->estado_id = 1;
        $banco->user_id = Auth::user()->id;
        $banco->save();

        event(new ActualizacionBitacora($banco->id, Auth::user()->id, 'Creación', '', $banco, 'Banco'));

        return redirect()->route('bancos.index')->withFlash('El banco se ha registrado exitosamente');
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
    public function edit(Banco $banco)
    {
        return view('admin.bancos.edit', compact('banco'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banco $banco)
    {
        $banco->update($request->all());

        event(new ActualizacionBitacora($banco->id, Auth::user()->id, 'Edición', '', $banco, 'banco'));

        return redirect()->route('bancos.index')->withFlash('El banco se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Banco $banco)
    {
        $banco->estado_id = 2;
        $banco->save();

        event(new ActualizacionBitacora($banco->id, Auth::user()->id, 'Inactivación', '', '', 'bancos'));

        return Response::json(['success'=> 'Éxito']);
    }

    public function activar(Request $request, Banco $banco)
    {
          $banco->estado_id = 1;
          $banco->save();
       
          event(new ActualizacionBitacora($banco->id, Auth::user()->id, 'Activación', '', '', 'bancos'));

          return Response::json(['success'=> 'Éxito']);
     }

}
