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
use App\Tienda;
use App\Events\ActualizacionBitacora;
use Validator;

class TiendasController extends Controller
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

        return view ("admin.tiendas.index");
    }

    public function getJson(Request $params)
     {
         $api_Result['data'] = Tienda::select(
             'tiendas.id',
             'tiendas.tienda',
             'tiendas.descripcion',
             'tiendas.estado_id',
             'tiendas.created_at'
         )->join(
             'estados',
             'tiendas.estado_id',
             '=',
             'estados.id'
         )->where(
             'tiendas.estado_id',
             '<',
             '3'
         )->get(); 

         return Response::json( $api_Result );
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ("admin.tiendas.create");
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
        $tienda = Tienda::create($data);
        $tienda->estado_id = 1;
        $tienda->user_id = Auth::user()->id;
        $tienda->save();

        event(new ActualizacionBitacora($tienda->id, Auth::user()->id,'Creacion','', $tienda,'tiendas'));
        return redirect()->route('tiendas.index')->withFlash('La tienda ha sido creado exitosamente!');
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
