<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Usuario_Tienda;
use App\Events\ActualizacionBitacora;
use App\Tienda;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class UsuarioTiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.usuario_tienda.index');
    }

    public function getJson(Request $params){

        $api_Result['data'] = Usuario_Tienda::select(
            'usuarios_tiendas.id',
            'users.name', 
            'tiendas.tienda', 
            'usuarios_tiendas.estado_id',
            'estados.estado',
            'usuarios_tiendas.created_at'
        )->join(
            'users', 
            'usuarios_tiendas.user_id', 
            '=', 
            'users.id'
        )->join(
            'tiendas', 
            'usuarios_tiendas.tienda_id', 
            '=', 
            'tiendas.id'
        )->join(
            'estados', 
            'usuarios_tiendas.estado_id', 
            '=', 
            'estados.id'
        )->where(
            'users.id', 
            '>=', 
            2
        )->get();

        return Response::json($api_Result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = "SELECT us.id, us.name
        FROM users us
        LEFT JOIN usuarios_tiendas ut
        ON us.id = ut.user_id
        WHERE ut.user_id IS null";

        $usuarios = DB::select($query);
        
        $tiendas = Tienda::Where("estado_id","=",1)->get();
        
        return view('admin.usuario_tienda.create', compact('usuarios', 'tiendas'));
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
        $usuario_tienda = Usuario_Tienda::create($data);
        $usuario_tienda->estado_id = 1;
        $usuario_tienda->save();

        event(new ActualizacionBitacora($usuario_tienda->id, Auth::user()->id, 'Creación', '', $usuario_tienda, 'asignación'));

        return redirect()->route('usuario_tienda.index')->withFlash('La asignación se ha registrado exitosamente');
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
    public function edit(Usuario_Tienda $usuario_tienda)
    {
        $usuarios = User::Where("estado",1)->Where("id",">",3)->get();

        $tiendas = Tienda::Where("estado_id","=",1)->get();
        
        return view('admin.usuario_tienda.edit', compact('usuarios', 'tiendas', 'usuario_tienda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario_Tienda $usuario_tienda)
    {
        $usuario_tienda->update($request->all());

        event(new ActualizacionBitacora($usuario_tienda->id, Auth::user()->id, 'Edición', '', $usuario_tienda, 'asignación'));

        return redirect()->route('usuario_tienda.index')->withFlash('La asignación se ha modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario_Tienda $usuario_tienda, Request $request)
    {
        $usuario_tienda->estado_id = 2;
        $usuario_tienda->save();

        event(new ActualizacionBitacora($usuario_tienda->id, Auth::user()->id, 'Desactivado', '', '', 'Asignación'));

        return Response::json(['success' => 'Éxito']);
    }

    public function activar(Usuario_Tienda $usuario_tienda, Request $request)
    {
        $usuario_tienda->estado_id = 1;
        $usuario_tienda->save();

        event(new ActualizacionBitacora($usuario_tienda->id, Auth::user()->id, 'Activación', '', '', 'Asignación'));

        return Response::json(['success' => 'Éxito']);
    
    }
}
