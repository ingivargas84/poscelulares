<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\RubroGasto;
use App\Events\ActualizacionBitacora;
use Validator;

class RubroGastoController extends Controller
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

        return view ("admin.rubro_gasto.index");
    }

    public function getJson(Request $params)
     {
         $api_Result['data'] = RubroGasto::all(); 

         return Response::json( $api_Result );
     }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ("admin.rubro_gasto.create");
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
        $rg = RubroGasto::create($data);
        $rg->save();

        event(new ActualizacionBitacora($rg->id, Auth::user()->id, 'Creación', '', $rg, 'rubro gasto'));

        return redirect()->route('rubro_gasto.index')->withFlash('El rubro de gasto se ha registrado exitosamente');
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
    public function edit(RubroGasto $rubro_gasto )
    {
        return view('admin.rubro_gasto.edit', compact('rubro_gasto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, RubroGasto $rubro_gasto)
    {
        $rubro_gasto->update($request->all());


        event(new ActualizacionBitacora($rubro_gasto->id, Auth::user()->id, 'Edición', '', $rubro_gasto, 'rubro de gasto'));

        return redirect()->route('rubro_gasto.index')->withFlash('El rubro de gasto se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request, RubroGasto $rubro_gasto)
    {
        $rubro_gasto->delete();

        event(new ActualizacionBitacora($rubro_gasto->id, Auth::user()->id, 'Eliminación',$rubro_gasto->rubro_gasto , '', 'Rubro Gasto'));

        return Response::json(['success' => 'Éxito']);
    }
}
