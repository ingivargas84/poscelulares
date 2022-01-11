<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Events\ActualizacionBitacora;
use App\territorios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Client;

class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.clientes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = Cliente::create([
            'nit'                => $request->nit,
            'nombre_cliente'     => $request->nombre_cliente,
            'dias_credito'       => $request->dias_credito,
            'direccion'          => $request->direccion,
            'email'              => $request->email,
            'fec_nacimiento'     => date_format(date_create($request->fec_nacimiento), "Y/m/d"),
            'telefonos'          => $request->telefonos,
            'estado'             => 1,
            'user_id'            => Auth::user()->id,
        ]);
        $cliente->save();

        event(new ActualizacionBitacora($cliente->id, Auth::user()->id, 'Creación', '', $cliente, 'clientes'));

        return redirect()->route('clientes.index')->withFlash('El cliente se ha registrado exitosamente');
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
    public function edit(Cliente $cliente)
    {
        $territorios = territorios::all();
        return view('admin.clientes.edit', compact('cliente', 'territorios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $this->validate($request,[
            'nombre_cliente' => 'required'
        ]);
        $nuevos_datos = array(
            'nit' => $request->nit,
            'nombre_cliente' => $request->nombre_cliente,
            'dias_credito' => $request->dias_credito,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'fec_nacimiento' => date_format(date_create($request->fec_nacimiento), "Y/m/d"),
            'telefonos' => $request->telefonos
        );

        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($cliente->id, Auth::user()->id, 'Edición', $cliente, $json, 'clientes'));

        $cliente->update([
            'nit'                => $request->nit,
            'nombre_cliente'     => $request->nombre_cliente,
            'dias_credito'       => $request->dias_credito,
            'direccion'          => $request->direccion,
            'email'              => $request->email,
            'fec_nacimiento'     => date_format(date_create($request->fec_nacimiento), "Y/m/d"),
            'telefonos'          => $request->telefonos,
        ]);

        return redirect()->route('clientes.index', $cliente)->withFlash('El cliente se ha actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente, Request $request)
    {
        $cliente->estado = 2;
        $cliente->save();

        event(new ActualizacionBitacora($cliente->id, Auth::user()->id, 'Inactivación', '', '', 'clientes'));

        return Response::json(['success'=>'Éxito']);
    }

    public function activar(Cliente $cliente, Request $request)
    {
        $cliente->estado = 1;
        $cliente->save();

        event(new ActualizacionBitacora($cliente->id, Auth::user()->id, 'Activación', '', '', 'clientes'));

        return Response::json(['success'=> 'Éxito']);
    }

    public function getJson(Request $params)
    {
        $api_Result['data'] = Cliente::select(
            'clientes.nombre_cliente', 'clientes.nit', 'clientes.direccion',
            'clientes.estado', 'clientes.id'
                )->get();
        return Response::json($api_Result);
    }
    
    public function nitDisponible()
    {
        $dato = Input::get("nit");
        $query = Cliente::where("nit", $dato)->get();
        $contador = count($query);
        if ($contador == 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

}
