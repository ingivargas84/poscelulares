<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\FacturasController;

Route::group([
    'middleware'=>['auth','estado'] ],
function(){
    Route::get('/admin','HomeController@index')->name('dashboard');
    Route::get('/admin/salesData','HomeController@getSalesData')->name('dashboard.salesData');
    Route::get('/admin/purchaseData','HomeController@getPurchaseData')->name('dashboard.purchaseData');
    Route::get('/admin/facturaData','HomeController@getFacturaData')->name('dashboard.facturaData');
    Route::get('/admin/abonoData','HomeController@getAbonoData')->name('dashboard.abonoData');

    Route::get('user/getJson' , 'UsersController@getJson' )->name('users.getJson');
    Route::get('users' , 'UsersController@index' )->name('users.index');
    Route::post('users' , 'UsersController@store' )->name('users.store');
    Route::delete('users/{user}' , 'UsersController@destroy' );
    Route::post('users/update/{user}' , 'UsersController@update' );
    Route::get('users/{user}/edit', 'UsersController@edit' );
    Route::post('users/reset/tercero' , 'UsersController@resetPasswordTercero')->name('users.reset.tercero');
    Route::post('users/reset' , 'UsersController@resetPassword')->name('users.reset');
    Route::get( '/users/cargar' , 'UsersController@cargarSelect')->name('users.cargar');
    Route::get( '/users/cargarA' , 'UsersController@cargarSelectApertura')->name('users.cargarA');

    Route::get( '/negocio/{negocio}/edit' , 'NegocioController@edit')->name('negocio.edit');
    Route::put( '/negocio/{negocio}/update' , 'NegocioController@update')->name('negocio.update');

    Route::get( '/proveedores' , 'ProveedoresController@index')->name('proveedores.index');
    Route::get( '/proveedores/getJson/' , 'ProveedoresController@getJson')->name('proveedores.getJson');
    Route::get( '/proveedores/new' , 'ProveedoresController@create')->name('proveedores.new');
    Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit')->name('proveedores.edit');
    Route::put( '/proveedores/{proveedor}/update' , 'ProveedoresController@update')->name('proveedores.update');
    Route::post( '/proveedores/save/' , 'ProveedoresController@store')->name('proveedores.save');
    Route::post('/proveedores/{proveedor}/desactivar' , 'ProveedoresController@destroy');
    Route::post('/proveedores/{proveedor}/activar' , 'ProveedoresController@activar');
    Route::get('/proveedores/nitDisponible/', 'ProveedoresController@nitDisponible')->name('proveedores.nitDisponible');

    Route::get( '/tiendas' , 'TiendasController@index')->name('tiendas.index');
    Route::get( '/tiendas/getJson/' , 'TiendasController@getJson')->name('tiendas.getJson');
    Route::get( '/tiendas/new' , 'TiendasController@create')->name('tiendas.new');
    Route::post( '/tiendas/save/' , 'TiendasController@store')->name('tiendas.save');
    Route::get( '/tiendas/edit/{tienda}' , 'TiendasController@edit')->name('tiendas.edit');
    Route::put( '/tiendas/{tienda}/update' , 'TiendasController@update')->name('tiendas.update');
    Route::post('/tiendas/{tienda}/activar' , 'TiendasController@activar');
    Route::post('/tiendas/{tienda}/desactivar' , 'TiendasController@desactivar');
    Route::post('/tiendas/{tienda}/delete' , 'TiendasController@destroy');

    Route::get( '/marcas' , 'MarcaController@index')->name('marcas.index');
    Route::get( '/marcas/getJson/' , 'MarcaController@getJson')->name('marcas.getJson');
    Route::get( '/marcas/new' , 'MarcaController@create')->name('marcas.new');
    Route::post( '/marcas/save/' , 'MarcaController@store')->name('marcas.save');
    Route::get( '/marcas/edit/{marca}' , 'MarcaController@edit')->name('marcas.edit');
    Route::put( '/marcas/{marca}/update' , 'MarcaController@update')->name('marcas.update');
    Route::post('/marcas/{marca}/activar' , 'MarcaController@activar');
    Route::post('/marcas/{marca}/desactivar' , 'MarcaController@desactivar');
    Route::post('/marcas/{marca}/delete' , 'MarcaController@destroy');
    Route::get('/marcas/marcaDisponible' , 'MarcaController@marcaDisponible')->name('marcas.marcasDisponible');

    Route::get( '/gastos' , 'GastosController@index')->name('gastos.index');
    Route::get( '/gastos/getJson/' , 'GastosController@getJson')->name('gastos.getJson');
    Route::get( '/gastos/new' , 'GastosController@create')->name('gastos.new');
    Route::post( '/gastos/save/' , 'GastosController@store')->name('gastos.save');
    Route::get( '/gastos/edit/{gasto}' , 'GastosController@edit')->name('gastos.edit');
    Route::put( '/gastos/{gasto}/update' , 'GastosController@update')->name('gastos.update');
    Route::post('/gastos/{gasto}/activar' , 'GastosController@activar');
    Route::post('/gastos/{gasto}/desactivar' , 'GastosController@desactivar');
    Route::post('/gastos/{gasto}/delete' , 'GastosController@destroy');

    Route::get( '/usuario_tienda' , 'UsuarioTiendaController@index')->name('usuario_tienda.index');
    Route::get( '/usuario_tienda/getJson/' , 'UsuarioTiendaController@getJson')->name('usuario_tienda.getJson');
    Route::get( '/usuario_tienda/new' , 'UsuarioTiendaController@create')->name('usuario_tienda.new');
    Route::post( '/usuario_tienda/save/' , 'UsuarioTiendaController@store')->name('usuario_tienda.save');
    Route::get( '/usuario_tienda/edit/{usuario_tienda}' , 'UsuarioTiendaController@edit')->name('usuario_tienda.edit');
    Route::put( '/usuario_tienda/{usuario_tienda}/update' , 'UsuarioTiendaController@update')->name('usuario_tienda.update');
    Route::post('/usuario_tienda/{usuario_tienda}/activar' , 'UsuarioTiendaController@activar');
    Route::post('/usuario_tienda/{usuario_tienda}/desactivar' , 'UsuarioTiendaController@desactivar');
    Route::post('/usuario_tienda/{usuario_tienda}/delete' , 'UsuarioTiendaController@destroy');

    Route::get( '/bodegamaxmin' , 'BodegasMaxMinController@index')->name('bodegamaxmin.index');
    Route::get( '/bodegamaxmin/getJson/' , 'BodegasMaxMinController@getJson')->name('bodegamaxmin.getJson');
    Route::get( '/bodegamaxmin/new' , 'BodegasMaxMinController@create')->name('bodegamaxmin.new');
    Route::post( '/bodegamaxmin/save/' , 'BodegasMaxMinController@store')->name('bodegamaxmin.save');
    Route::get( '/bodegamaxmin/edit/{bodegamaxmin}' , 'BodegasMaxMinController@edit')->name('bodegamaxmin.edit');
    Route::put( '/bodegamaxmin/{bodegamaxmin}/update' , 'BodegasMaxMinController@update')->name('bodegamaxmin.update');
    Route::post('/bodegamaxmin/{bodegamaxmin}/activar' , 'BodegasMaxMinController@activar');
    Route::post('/bodegamaxmin/{bodegamaxmin}/desactivar' , 'BodegasMaxMinController@desactivar');
    Route::post('/bodegamaxmin/{bodegamaxmin}/delete' , 'BodegasMaxMinController@destroy');
    Route::get('/bodegamaxmin/getMaxmin' , 'BodegasMaxMinController@getMaxmin')->name('bodegamaxmin.getMaxmin');

    Route::get( '/modelos' , 'ModelosController@index')->name('modelos.index');
    Route::get( '/modelos/getJson/' , 'ModelosController@getJson')->name('modelos.getJson');
    Route::get( '/modelos/new' , 'ModelosController@create')->name('modelos.new');
    Route::post( '/modelos/save/' , 'ModelosController@store')->name('modelos.save');
    Route::get( '/modelos/edit/{modelo}' , 'ModelosController@edit')->name('modelos.edit');
    Route::put( '/modelos/{modelo}/update' , 'ModelosController@update')->name('modelos.update');
    Route::post('/modelos/{modelo}/activar' , 'ModelosController@activar');
    Route::post('/modelos/{modelo}/desactivar' , 'ModelosController@desactivar');
    Route::post('/modelos/{modelo}/delete' , 'ModelosController@destroy');
    Route::get('/modelos/getModelos' , 'ModelosController@getModelos')->name('modelos.getModelos');

    Route::get( '/companias' , 'CompaniasController@index')->name('companias.index');
    Route::get( '/companias/getJson/' , 'CompaniasController@getJson')->name('companias.getJson');
    Route::get( '/companias/new' , 'CompaniasController@create')->name('companias.new');
    Route::post( '/companias/save/' , 'CompaniasController@store')->name('companias.save');
    Route::get( '/companias/edit/{compania}' , 'CompaniasController@edit')->name('companias.edit');
    Route::put( '/companias/{compania}/update' , 'CompaniasController@update')->name('companias.update');
    Route::post('/companias/{compania}/activar' , 'CompaniasController@activar');
    Route::post('/companias/{compania}/desactivar' , 'CompaniasController@desactivar');
    Route::post('/companias/{compania}/delete' , 'CompaniasController@destroy');
    Route::get('/companias/nombreDisponible/', 'CompaniasController@nombreDisponible')->name('companias.nombreDisponible');

    Route::get( '/visitas' , 'VisitaController@index')->name('visitas.index');
    Route::get( '/visitas/getJson/' , 'VisitaController@getJson')->name('visitas.getJson');
    Route::get( '/visitas/new' , 'VisitaController@create')->name('visitas.new');
    Route::get( '/visitas/new2' , 'VisitaController@create2')->name('visitas.new2');
    Route::post( '/visitas/save/' , 'VisitaController@store')->name('visitas.save');
    Route::post( '/visitas/save2/' , 'VisitaController@store2')->name('visitas.save2');
    Route::get( '/visitas/edit/{visita}' , 'VisitaController@edit')->name('visitas.edit');
    Route::put( '/visitas/{visita}/update' , 'VisitaController@update')->name('visitas.update');
    Route::post('/visitas/{visita}/delete' , 'VisitaController@destroy');

    Route::get( '/clientes' , 'ClientesController@index')->name('clientes.index');
    Route::get( '/clientes/getJson/' , 'ClientesController@getJson')->name('clientes.getJson');
    Route::get( '/clientes/new' , 'ClientesController@create')->name('clientes.new');
    Route::get( '/clientes/edit/{cliente}' , 'ClientesController@edit')->name('clientes.edit');
    Route::put( '/clientes/{cliente}/update' , 'ClientesController@update')->name('clientes.update');
    Route::post( '/clientes/save/' , 'ClientesController@store')->name('clientes.save');
    Route::post('/clientes/{cliente}/delete' , 'ClientesController@destroy');
    Route::post('/clientes/{cliente}/activar' , 'ClientesController@activar');
    Route::get('/clientes/nitDisponible/', 'ClientesController@nitDisponible')->name('clientes.nitDisponible');

    Route::get( '/bodegas' , 'BodegasController@index')->name('bodegas.index');
    Route::get( '/bodegas/getJson/' , 'BodegasController@getJson')->name('bodegas.getJson');
    Route::get( '/bodegas/new' , 'BodegasController@create')->name('bodegas.new');
    Route::post( '/bodegas/save/' , 'BodegasController@store')->name('bodegas.save');
    Route::get( '/bodegas/edit/{bodega}' , 'BodegasController@edit')->name('bodegas.edit');
    Route::put( '/bodegas/{bodega}/update' , 'BodegasController@update')->name('bodegas.update');
    Route::post( '/bodegas/save/' , 'BodegasController@store')->name('bodegas.save');
    Route::post('/bodegas/{bodega}/delete' , 'BodegasController@destroy');
    Route::post('/bodegas/{bodega}/activar' , 'BodegasController@activar');

    Route::get( '/bancos' , 'BancosController@index')->name('bancos.index');
    Route::get( '/bancos/getJson/' , 'BancosController@getJson')->name('bancos.getJson');
    Route::get( '/bancos/new' , 'BancosController@create')->name('bancos.new');
    Route::post( '/bancos/save/' , 'BancosController@store')->name('bancos.save');
    Route::get( '/bancos/edit/{banco}' , 'BancosController@edit')->name('bancos.edit');
    Route::put( '/bancos/{banco}/update' , 'BancosController@update')->name('bancos.update');
    Route::post( '/bancos/save/' , 'BancosController@store')->name('bancos.save');
    Route::post('/bancos/{banco}/delete' , 'BancosController@destroy');
    Route::post('/bancos/{banco}/activar' , 'BancosController@activar');

    Route::get( '/bancostiendas' , 'BancosTiendasController@index')->name('bancostiendas.index');
    Route::get( '/bancostiendas/getJson/' , 'BancosTiendasController@getJson')->name('bancostiendas.getJson');
    Route::get( '/bancostiendas/new' , 'BancosTiendasController@create')->name('bancostiendas.new');
    Route::post( '/bancostiendas/save/' , 'BancosTiendasController@store')->name('bancostiendas.save');
    Route::get( '/bancostiendas/edit/{bancos_tiendas}' , 'BancosTiendasController@edit')->name('bancostiendas.edit');
    Route::put( '/bancostiendas/{bancos_tiendas}/update' , 'BancosTiendasController@update')->name('bancostiendas.update');
    Route::post( '/bancostiendas/save/' , 'BancosTiendasController@store')->name('bancostiendas.save');
    Route::post('/bancostiendas/{bancotienda}/delete' , 'BancosTiendasController@destroy');

    Route::get( '/transacciones' , 'TransaccionesController@index')->name('transacciones.index');
    Route::get( '/transacciones/getJson/' , 'TransaccionesController@getJson')->name('transacciones.getJson');
    Route::get( '/transacciones/new' , 'TransaccionesController@create')->name('transacciones.new');
    Route::post( '/transacciones/save/' , 'TransaccionesController@store')->name('transacciones.save');
    Route::get( '/transacciones/edit/{transaccion}' , 'TransaccionesController@edit')->name('transacciones.edit');
    Route::put( '/transacciones/{transaccion}/update' , 'TransaccionesController@update')->name('transacciones.update');
    Route::post('/transacciones/{transaccion}/activar' , 'TransaccionesController@activar');
    Route::post('/transacciones/{transaccion}/desactivar' , 'TransaccionesController@desactivar');
    Route::post('/transacciones/{transaccion}/delete' , 'TransaccionesController@destroy');

    Route::get( '/traslados_bancos' , 'TrasladosBancosController@index')->name('traslados_bancos.index');
    Route::get( '/traslados_bancos/getJson/' , 'TrasladosBancosController@getJson')->name('traslados_bancos.getJson');
    Route::get( '/traslados_bancos/new' , 'TrasladosBancosController@create')->name('traslados_bancos.new');
    Route::post( '/traslados_bancos/save/' , 'TrasladosBancosController@store')->name('traslados_bancos.save');
    Route::get( '/traslados_bancos/edit/{traslados_bancos}' , 'TrasladosBancosController@edit')->name('traslados_bancos.edit');
    Route::put( '/traslados_bancos/{traslados_bancos}/update' , 'TrasladosBancosController@update')->name('traslados_bancos.update');
    Route::post('/traslados_bancos/{traslados_bancos}/activar' , 'TrasladosBancosController@activar');
    Route::post('/traslados_bancos/{traslados_bancos}/desactivar' , 'TrasladosBancosController@desactivar');
    Route::post('/traslados_bancos/{traslados_bancos}/delete' , 'TrasladosBancosController@destroy');

    Route::get( '/saldos_bancos' , 'SaldosBancosController@index')->name('saldos_bancos.index');
    Route::get( '/saldos_bancos/getJson/' , 'SaldosBancosController@getJson')->name('saldos_bancos.getJson');
    Route::get( '/saldos_bancos/new' , 'SaldosBancosController@create')->name('saldos_bancos.new');
    Route::post( '/saldos_bancos/save/' , 'SaldosBancosController@store')->name('saldos_bancos.save');
    Route::get( '/saldos_bancos/edit/{saldos_bancos}' , 'SaldosBancosController@edit')->name('saldos_bancos.edit');
    Route::put( '/saldos_bancos/{saldos_bancos}/update' , 'SaldosBancosController@update')->name('saldos_bancos.update');
    Route::post('/saldos_bancos/{saldos_bancos}/activar' , 'SaldosBancosController@activar');
    Route::post('/saldos_bancos/{saldos_bancos}/desactivar' , 'SaldosBancosController@desactivar');
    Route::post('/saldos_bancos/{saldos_bancos}/delete' , 'SaldosBancosController@destroy');

    Route::get( '/formas_pago' , 'FormasPagoController@index')->name('formas_pago.index');
    Route::get( '/formas_pago/getJson/' , 'FormasPagoController@getJson')->name('formas_pago.getJson');
    Route::get( '/formas_pago/new' , 'FormasPagoController@create')->name('formas_pago.new');
    Route::get( '/formas_pago/edit/{formaPago}' , 'FormasPagoController@edit')->name('formas_pago.edit');
    Route::put( '/formas_pago/{formaPago}/update' , 'FormasPagoController@update')->name('formas_pago.update');
    Route::post( '/formas_pago/save/' , 'FormasPagoController@store')->name('formas_pago.save');
    Route::post('/formas_pago/{formaPago}/delete' , 'FormasPagoController@destroy');
    // Route::post('/formas_pago/{formaPago}/activar' , 'FormasPagoController@activar');
    Route::get('/formas_pago/nombreDisponible/', 'FormasPagoController@nombreDisponible')->name('formas_pago.nombreDisponible');

    Route::get( '/rubro_gasto' , 'RubroGastoController@index')->name('rubro_gasto.index');
    Route::get( '/rubro_gasto/getJson/' , 'RubroGastoController@getJson')->name('rubro_gasto.getJson');
    Route::get( '/rubro_gasto/new' , 'RubroGastoController@create')->name('rubro_gasto.new');
    Route::post( '/rubro_gasto/save/' , 'RubroGastoController@store')->name('rubro_gasto.save');
    Route::get( '/rubro_gasto/edit/{rubro_gasto}' , 'RubroGastoController@edit')->name('rubro_gasto.edit');
    Route::put( '/rubro_gasto/{rubro_gasto}/update' , 'RubroGastoController@update')->name('rubro_gasto.update');
    Route::post('/rubro_gasto/{rubro_gasto}/delete' , 'RubroGastoController@destroy');

    Route::get( '/presentaciones_producto' , 'PresentacionesProductoController@index')->name('presentaciones_producto.index');
    Route::get( '/presentaciones_producto/getJson/' , 'PresentacionesProductoController@getJson')->name('presentaciones_producto.getJson');
    Route::get( '/presentaciones_producto/new' , 'PresentacionesProductoController@create')->name('presentaciones_producto.new');
    Route::get( '/presentaciones_producto/edit/{presentacionProducto}' , 'PresentacionesProductoController@edit')->name('presentaciones_producto.edit');
    Route::put( '/presentaciones_producto/{presentacionProducto}/update' , 'PresentacionesProductoController@update')->name('presentaciones_producto.update');
    Route::post( '/presentaciones_producto/save/' , 'PresentacionesProductoController@store')->name('presentaciones_producto.save');
    Route::post('/presentaciones_producto/{presentacionProducto}/delete' , 'PresentacionesProductoController@destroy');
    // Route::post('/presentaciones_producto/{presentacionProducto}/activar' , 'PresentacionesProductoController@activar');
    Route::get('/presentaciones_producto/nombreDisponible/', 'PresentacionesProductoController@nombreDisponible')->name('presentaciones_producto.nombreDisponible');

    Route::get( '/productos' , 'ProductosController@index')->name('productos.index');
    Route::get( '/productos/getJson/' , 'ProductosController@getJson')->name('productos.getJson');
    Route::get( '/productos/new' , 'ProductosController@create')->name('productos.new');
    Route::get( '/productos/edit/{producto}' , 'ProductosController@edit')->name('productos.edit');
    Route::put( '/productos/{producto}/update' , 'ProductosController@update')->name('productos.update');
    Route::post( '/productos/save/' , 'ProductosController@store')->name('productos.save');
    Route::get('/productos/show/{producto}' , 'ProductosController@show')->name('productos.show');
    Route::post('/productos/{producto}/delete' , 'ProductosController@destroy');
    Route::post('/productos/{producto}/eliminar' , 'ProductosController@eliminar');
    Route::post('/productos/{producto}/activar' , 'ProductosController@activar');
    Route::get('/productos/codigoDisponible' , 'ProductosController@codigoDisponible')->name('productos.codigoDisponible');
    Route::get('/productos/getModelos/{marca}' , 'ProductosController@getModelos')->name('productos.getModelos');
    Route::get('/productos/getProductos/' , 'ProductosController@getProductos')->name('productos.getProductos');
    Route::get('/productos/getCodigos' , 'ProductosController@getCodigos')->name('productos.getCodigos');


    Route::get( '/recargas' , 'SaldoRecargasController@index')->name('recargas.index');
    Route::get( '/recargas/getJson/' , 'SaldoRecargasController@getJson')->name('recargas.getJson');
    Route::get( '/recargas/new' , 'SaldoRecargasController@create')->name('recargas.new');
    Route::post( '/recargas/save/' , 'SaldoRecargasController@store')->name('recargas.save');
    Route::get( '/recargas/newm' , 'SaldoRecargasController@createm')->name('recargas.newm');
    Route::post( '/recargas/savem/' , 'SaldoRecargasController@storem')->name('recargas.savem');
    Route::get( '/recargas/newt' , 'SaldoRecargasController@createt')->name('recargas.newt');
    Route::post( '/recargas/savet/' , 'SaldoRecargasController@storet')->name('recargas.savet');
    Route::get('/recargas/edit/{saldorecargas}' , 'SaldoRecargasController@edit')->name('recargas.edit');
    Route::put('/recargas/{saldorecargas}/update' , 'SaldoRecargasController@update')->name('recargas.update');


    Route::get('/compras/getProductoData/{producto}' , 'ComprasController@getProductoData')->name('compras.getProductoData');
    Route::get('/compras/getProductoDataNombre/{producto}' , 'ComprasController@getProductoDataNombre')->name('compras.getProductoData');
    Route::get('/compras' , 'ComprasController@index')->name('compras.index');
    Route::get('/compras/getJson/' , 'ComprasController@getJson')->name('compras.getJson');
    Route::get('/compras/new' , 'ComprasController@create')->name('compras.new');
    Route::post( '/compras/save/' , 'ComprasController@store')->name('compras.save');
    Route::get('/compras/{ingresoMaestro}' , 'ComprasController@show')->name('compras.show');
    Route::get('/compras/edit/{compra}' , 'ComprasController@edit')->name('compras.edit');
    Route::put('/compras/{compra}/update' , 'ComprasController@update')->name('compras.update');
    Route::post('/compras/{ingresoMaestro}/delete' , 'ComprasController@destroy');
    Route::post('/compras/{ingresoDetalle}/deleteDetalle' , 'ComprasController@destroyDetalle');
    Route::get('/compras/{ingresoMaestro}/getDetalles' , 'ComprasController@getDetalles')->name('compras.getDetalles');
    Route::get('/compras/imei/{ingresoDetalle}' , 'ComprasController@imei');
    Route::post( '/compras/saveimei/' , 'ComprasController@storeimei')->name('compras.saveimei');
    Route::get('/compras/getImei/{imei}' , 'ComprasController@getImei')->name('compras.getImei');

    Route::get( '/compras/editimei/{producto_imei}' , 'ComprasController@editimei')->name('compras.editimei');
    Route::put( '/compras/{productos_imei}/updateimei' , 'ComprasController@updateimei')->name('compras.updateimei');
    Route::get( '/compras/getimeis/{ingresoDetalle}' , 'ComprasController@getimeis')->name('compras.getimeis');

    Route::get('/productos_imei' , 'ComprasController@indeximei')->name('compras.indeximei');
    Route::get('/productos_imei/getJson/' , 'ComprasController@getJsonimei')->name('compras.getJsonimei');

    Route::get('/traspasos_bodega/getJson/' , 'TraspasosBodegaController@getJson')->name('traspasos_bodega.getJson');
    Route::get('/traspasos_bodega/getProducto/{producto}/{bodega}' , 'TraspasosBodegaController@getProduct')->name('traspasos_bodega.getProducto');
    Route::get('/traspasos_bodega/getProductoNombre/{producto}/{bodega}' , 'TraspasosBodegaController@getProductName')->name('traspasos_bodega.getProducto');
    Route::get('/traspasos_bodega' , 'TraspasosBodegaController@index')->name('traspasos_bodega.index');
    Route::get('/traspasos_bodega/new' , 'TraspasosBodegaController@create')->name('traspasos_bodega.new');
    Route::post( '/traspasos_bodega/save/' , 'TraspasosBodegaController@store')->name('traspasos_bodega.save');
    Route::get('/traspasos_bodega/show/{traspasoBodega}' , 'TraspasosBodegaController@show')->name('traspasos_bodega.show');
    Route::get('/traspasos_bodega/{traspasoBodega}' , 'TraspasosBodegaController@show')->name('traspasos_bodega.show');
    Route::get('/traspasos_bodega/edit/{compra}' , 'TraspasosBodegaController@edit')->name('traspasos_bodega.edit');
    Route::put('/traspasos_bodega/{compra}/update' , 'TraspasosBodegaController@update')->name('traspasos_bodega.update');
    Route::post('/traspasos_bodega/{traspasoBodega}/delete' , 'TraspasosBodegaController@destroy');
    Route::post('/traspasos_bodega/{ingresoDetalle}/deleteDetalle' , 'TraspasosBodegaController@destroyDetalle');
    Route::get('/traspasos_bodega/{traspasoBodega}/getDetalles' , 'TraspasosBodegaController@getDetalles')->name('traspasos_bodega.getDetalles');
    Route::get('/traspasos_bodega/getProductoData/{producto}/{bodega_id}' , 'TraspasosBodegaController@getProductoData');

    Route::get('/pedidos/getJson/' , 'PedidosController@getJson')->name('pedidos.getJson');
    Route::get('/pedidos/getProductoData/{producto}/{bodega}' , 'PedidosController@getProductoData')->name('pedidos.getProductoData');
    Route::get('/pedidos/getProductoData1/{codigo}/{bodega}' , 'PedidosController@getProductoData1');
    Route::get('/pedidos/getFactura/{factura}' , 'PedidosController@getFactura')->name('pedidos.getFactura');
    Route::get('/pedidos' , 'PedidosController@index')->name('pedidos.index');
    Route::get('/pedidos/new' , 'PedidosController@create')->name('pedidos.new');
    Route::post('/pedidos/save/' , 'PedidosController@store')->name('pedidos.save');
    Route::post('/pedidos/save1/' , 'PedidosController@store1')->name('pedidos.save1');
    Route::get('/pedidos/newcontado' , 'PedidosController@createcontado')->name('pedidos.newcontado');
    Route::post('/pedidos/savecontado/' , 'PedidosController@storecontado')->name('pedidos.savecontado');
    Route::get('/pedidos/{pedidoMaestro}' , 'PedidosController@show')->name('pedidos.show');
    Route::post('/pedidos/{pedidoMaestro}/delete' , 'PedidosController@destroy');
    Route::post('/pedidos/{pedidoDetalle}/deleteDetalle' , 'PedidosController@destroyDetalle');
    Route::get('/pedidos/{pedidoMaestro}/getDetalles' , 'PedidosController@getDetalles')->name('pedidos.getDetalles');
    Route::get('/pedidos/{pedidoMaestro}/getDetalles1' , 'PedidosController@getDetalles1')->name('pedidos.getDetalles1');
    Route::get('/pedidos/editarDetalle/{id}' , 'PedidosController@editarDetalle')->name('pedidos.editarDetalle');
    Route::put('/pedidos/actulizarDetalle/{id}' , 'PedidosController@actulizarDetalle')->name('pedidos.actulizarDetalle');
    Route::get('/pedidos/getImei/{producto}/{bodega}' , 'PedidosController@getImei')->name('pedidos.getImei');

    Route::get('/cuentas_pagar/getJson/' , 'CuentasPagarController@getJson')->name('cuentas_pagar.getJson');
    Route::get('/cuentas_pagar' , 'CuentasPagarController@index')->name('cuentas_pagar.index');
    Route::get('/cuentas_pagar/new' , 'CuentasPagarController@create')->name('cuentas_pagar.new');
    Route::post('/cuentas_pagar/save/' , 'CuentasPagarController@store')->name('cuentas_pagar.save');
    Route::get('/cuentas_pagar/{cuentaPagarMaestro}' , 'CuentasPagarController@show')->name('cuentas_pagar.show');
    Route::post('/cuentas_pagar/{pedidoDetalle}/deleteAbono' , 'CuentasPagarController@destroyAbono');
    Route::get('/cuentas_pagar/{cuentaPagarMestro}/getDetalles' , 'CuentasPagarController@getDetalles')->name('cuentas_pagar.getDetalles');
    Route::get('/cuentas_pagar/monto/{id}' , 'CuentasPagarController@monto')->name('cuentas_pagar.monto');
    Route::get('/cuentas_pagar/facturas/{id}' , 'CuentasPagarController@facturas')->name('cuentas_pagar.facturas');

    Route::get('/cuentas_cobrar/getJson/' , 'CuentasCobrarController@getJson')->name('cuentas_cobrar.getJson');
    Route::get('/cuentas_cobrar' , 'CuentasCobrarController@index')->name('cuentas_cobrar.index');
    Route::get('/cuentas_cobrar/new' , 'CuentasCobrarController@create')->name('cuentas_cobrar.new');
    Route::post('/cuentas_cobrar/save/' , 'CuentasCobrarController@store')->name('cuentas_cobrar.save');
    Route::get('/cuentas_cobrar/{cuentaPagarMaestro}' , 'CuentasCobrarController@show')->name('cuentas_cobrar.show');
    Route::post('/cuentas_cobrar/{id}/deleteAbono' , 'CuentasCobrarController@destroyAbono');
    Route::get('/cuentas_cobrar/{cuentaPagarMestro}/getDetalles' , 'CuentasCobrarController@getDetalles')->name('cuentas_cobrar.getDetalles');
    Route::get('/cuentas_cobrar/abonosParciales/{id}' , 'CuentasCobrarController@saldo')->name('cuentas_cobrar.saldo');

    Route::get('/notas_envio/getJson/' , 'NotasEnvioController@getJson')->name('notas_envio.getJson');
    Route::get('/notas_envio/getPedidoData/{pedidoMaestro}' , 'NotasEnvioController@getPedidoData')->name('notas_envio.getPedidoData');
    Route::get('/notas_envio/getFactura/{factura}' , 'NotasEnvioController@getFactura')->name('notas_envio.getFactura');
    Route::get('/notas_envio' , 'NotasEnvioController@index')->name('notas_envio.index');
    Route::get('/notas_envio/new' , 'NotasEnvioController@create')->name('notas_envio.new');
    Route::post('/notas_envio/save/' , 'NotasEnvioController@store')->name('notas_envio.save');
    Route::get('/notas_envio/edit/{notaEnvio}' , 'NotasEnvioController@edit');
    Route::put('/notas_envio/{notaEnvio}/update', 'NotasEnvioController@update');
    Route::post('/notas_envio/{notaEnvio}/delete' , 'NotasEnvioController@destroy');
    Route::post('/notas_envio/{pedidoDetalle}/deleteAbono' , 'NotasEnvioController@destroyAbono');
    Route::get('/notas_envio/{cuentaPagarMestro}/getDetalles' , 'NotasEnvioController@getDetalles')->name('notas_envio.getDetalles');

    

    Route::get('/facturas', 'FacturasController@index')->name('facturas.index');
    Route::get('/facturas/getJson', 'FacturasController@getJson')->name('facturas.getJson');
    Route::get('/facturas/new' , 'FacturasController@create')->name('facturas.new');
    Route::post('/facturas/save/' , 'FacturasController@store')->name('facturas.save');
    Route::get('/facturas/getVentaData/{pedido_maestro}' , 'FacturasController@getVentaData')->name('facturas.getVentaData');
    Route::get('/facturas/show/{id}', 'FacturasController@show')->name('facturas.show');
    Route::get('/facturas/delete/{id}', 'FacturasController@delete')->name('facturas.delete');
    Route::post('/facturas/destroy/', 'FacturasController@destroy')->name('facturas.destroy');
    Route::get('/facturas/NuevaFactura/{id}', 'FacturasController@NuevaFactura')->name('facturas.NuevaFactura');



    Route::get('/partidas_ajuste', 'PartidasAjusteController@index')->name('partidas_ajuste.index');
    Route::get('/partidas_ajuste/getJson', 'PartidasAjusteController@getJson')->name('partidas_ajuste.getJson');
    Route::get('/partidas_ajuste/{id}', 'PartidasAjusteController@show');
    Route::get('/partidas_ajuste/{id}/getDetalles', 'PartidasAjusteController@getDetalles');
    Route::get('/partidas_ajuste/new/{id}', 'PartidasAjusteController@create');
    Route::post('/partidas_ajuste/save', 'PartidasAjusteController@store')->name('partidas_ajuste.save');

    Route::get('/reportes/minmax' , 'ReportesController@minMaxJson')->name('reportes.minmax');
    Route::get('/reportes/stock' , 'ReportesController@stockJson')->name('reportes.stock');
    Route::get('/reportes/warehouseStock' , 'ReportesController@warehouseStockJson')->name('reportes.warehouse_stock');
    Route::get('/reportes/warehouseStock1' , 'ReportesController@warehouseStockVendedorJson')->name('reportes.warehouse_stock_vendedor');
    Route::get('/reportes/expiration' , 'ReportesController@expirationJson')->name('reportes.expiration');
    Route::get('/reportes/client_balance/{date}' , 'ReportesController@clientBalanceJson')->name('reportes.client_balance');
    Route::post('/reportes/visitas/' , 'ReportesController@pdfVisitas')->name('reportes.visitas');
    Route::get('/reportes/usuarios', 'ReportesController@getUsuarios')->name('reportes.usuarios');
    Route::post('/reportes/ventas', 'ReportesController@pdfVentasVendedor')->name('reportes.ventas');
    Route::post('/reportes/proveedores', 'ReportesController@pdfSaldoProveedores')->name('reportes.proveedores');
    Route::get('/reportes/compras', 'ReportesController@getProveedores');
    Route::get('/reportes/territorios', 'ReportesController@getTerritorios');
    Route::post('/reportes/comprasProveedores', 'ReportesController@reporteComprasProveedores')->name('reportes.comprasP');
    Route::post('/reportes/saldosTerritorios', 'ReportesController@reporteSaldosTerritorios')->name('reportes.saldosT');
    Route::post('/reportes/traspasoBodega', 'ReportesController@pdfTraspasoBodegas')->name('reportes.traspasoBodega');
    Route::post('/reportes/reporteMes', 'ReportesController@reporteMes')->name('reportes.reporteMes');
    Route::post('/reportes/liquidacionMensual', 'ReportesController@liquidacionMensual')->name('reportes.liquidacionMensual');
    Route::post('/reportes/reporteGanancias', 'ReportesController@reporteGanancias')->name('reportes.reporteGanancias');
    Route::post('/reportes/reporteAbonosClientes', 'ReportesController@reporteAbonosClientes')->name('reportes.reporteAbonosClientes');
    Route::get('/reportes/usuariosAbonos', 'ReportesController@getUsuariosAbonosClientes')->name('reportes.usuariosAbonos');

    
    Route::get( '/reportes/rpt_compras_fecha' , 'ReportesController@rpt_compras_fecha')->name('reportes.rpt_compras_fecha');
    Route::post( '/reportes/pdf_compras_fecha' , 'ReportesController@pdf_compras_fecha')->name('reportes.pdf_compras_fecha');

    Route::get( '/reportes/rpt_traspasos_bodegas' , 'ReportesController@rpt_traspasos_bodegas')->name('reportes.rpt_traspasos_bodegas');
    Route::post( '/reportes/pdf_traspasos_bodegas' , 'ReportesController@pdf_traspasos_bodegas')->name('reportes.pdf_traspasos_bodegas');
    
    Route::get( '/reportes/rpt_ventas_imei' , 'ReportesController@rpt_ventas_imei')->name('reportes.rpt_ventas_imei');
    Route::post( '/reportes/pdf_ventas_imei' , 'ReportesController@pdf_ventas_imei')->name('reportes.pdf_ventas_imei');

    Route::get( '/reportes/rpt_listado_imei' , 'ReportesController@rpt_listado_imei')->name('reportes.rpt_listado_imei');
    Route::post( '/reportes/pdf_listado_imei' , 'ReportesController@pdf_listado_imei')->name('reportes.pdf_listado_imei');

    Route::get( '/reportes/rpt_listado_gastos_fecha' , 'ReportesController@rpt_listado_gastos_fecha')->name('reportes.rpt_listado_gastos_fecha');
    Route::post( '/reportes/pdf_listado_gastos_fecha' , 'ReportesController@pdf_listado_gastos_fecha')->name('reportes.pdf_listado_gastos_fecha');

    Route::get( '/reportes/rpt_ventas_fecha_tienda' , 'ReportesController@rpt_ventas_fecha_tienda')->name('reportes.rpt_ventas_fecha_tienda');
    Route::post( '/reportes/pdf_ventas_fecha_tienda' , 'ReportesController@pdf_ventas_fecha_tienda')->name('reportes.pdf_ventas_fecha_tienda');

    Route::get( '/reportes/rpt_corte_caja' , 'ReportesController@rpt_corte_caja')->name('reportes.rpt_corte_caja');
    Route::post( '/reportes/pdf_corte_caja' , 'ReportesController@pdf_corte_caja')->name('reportes.pdf_corte_caja');

    Route::get( '/reportes/rpt_ventas_totales_tienda' , 'ReportesController@rpt_ventas_totales_tienda')->name('reportes.rpt_ventas_totales_tienda');
    Route::post( '/reportes/pdf_ventas_totales_tienda' , 'ReportesController@pdf_ventas_totales_tienda')->name('reportes.pdf_ventas_totales_tienda');

    Route::get( '/reportes/rpt_precio_compra_producto' , 'ReportesController@rpt_precio_compra_producto')->name('reportes.rpt_precio_compra_producto');
    Route::post( '/reportes/pdf_precio_compra_producto' , 'ReportesController@pdf_precio_compra_producto')->name('reportes.pdf_precio_compra_producto');

    Route::get( '/reportes/rpt_inventario_general_costos' , 'ReportesController@rpt_inventario_general_costos')->name('reportes.rpt_inventario_general_costos');
    Route::post( '/reportes/pdf_inventario_general_costos' , 'ReportesController@pdf_inventario_general_costos')->name('reportes.pdf_inventario_general_costos');

    Route::get( '/reportes/rpt_ventas_usuario' , 'ReportesController@rpt_ventas_usuario')->name('reportes.rpt_ventas_usuario');
    Route::post( '/reportes/pdf_ventas_usuario' , 'ReportesController@pdf_ventas_usuario')->name('reportes.pdf_ventas_usuario');

    Route::get( '/reportes/rpt_movimientos_bancarios' , 'ReportesController@rpt_movimientos_bancarios')->name('reportes.rpt_movimientos_bancarios');
    Route::post( '/reportes/pdf_movimientos_bancarios' , 'ReportesController@pdf_movimientos_bancarios')->name('reportes.pdf_movimientos_bancarios');

    Route::get( '/reportes/rpt_proyecciones' , 'ReportesController@rpt_proyecciones')->name('reportes.rpt_proyecciones');
    Route::post( '/reportes/pdf_proyecciones' , 'ReportesController@pdf_proyecciones')->name('reportes.pdf_proyecciones');

    Route::get( '/reportes/rpt_cuadre_inventario' , 'ReportesController@rpt_cuadre_inventario')->name('reportes.rpt_cuadre_inventario');
    Route::post( '/reportes/pdf_cuadre_inventario' , 'ReportesController@pdf_cuadre_inventario')->name('reportes.pdf_cuadre_inventario');

    Route::get( '/reportes/rpt_movimientos_productos' , 'ReportesController@rpt_movimientos_productos')->name('reportes.rpt_movimientos_productos');
    Route::post( '/reportes/pdf_movimientos_productos' , 'ReportesController@pdf_movimientos_productos')->name('reportes.pdf_movimientos_productos');

    Route::get( '/reportes/construccion' , 'ReportesController@construccion')->name('reportes.construccion');


    //devoluciones
    Route::get('/devoluciones/pedidos', 'PedidosController@getPedidos');
    Route::post('/devoluciones' , 'PedidosController@devolucion')->name('devoluciones.index');
    Route::get('/devoluciones/devolucion/{id}' , 'PedidosController@devoluciones')->name('devoluciones.getDetalles');
    Route::post('/devoluciones/save/' , 'PedidosController@storeDevoluciones')->name('pedidos.devoluciones');
});


Route::get('/', function () {
    $negocio = App\Negocio::all();
    return view('welcome', compact('negocio'));
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home')->middleware(['estado']);

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/user/get/' , 'Auth\LoginController@getInfo')->name('user.get');
Route::post('/user/contador' , 'Auth\LoginController@Contador')->name('user.contador');
Route::post('/password/reset2' , 'Auth\ForgotPasswordController@ResetPassword')->name('password.reset2');
Route::get('/user-existe/', 'Auth\LoginController@userExiste')->name('user.existe');

//Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
/*Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/
