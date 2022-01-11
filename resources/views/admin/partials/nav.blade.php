    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Navegacion</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{request()->is('admin')? 'active': ''}}">
            <a href="{{route('dashboard')}}">
                <i class="fa fa-home"></i>
                <span>Inicio</span>
            </a>
        </li>


        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="treeview {{request()->is('empleados*', 'puestos*','destinos_pedidos*','tipos_localidad*','localidades*','unidades_medida*','categorias_insumos*','insumos*', 'productos*', 'categorias_menus*', 'recetas*', 'cajas*')? 'active': ''}}">
            <a href="#"><i class="fa fa-book"></i> <span>Catálogos Generales</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('clientes')? 'active': ''}}"><a href="{{route('clientes.index')}}">
                        <i class="fas fa-user-tag"></i> Clientes</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('companias')? 'active': ''}}"><a href="{{route('companias.index')}}">
                        <i class="far fa-building"></i> Compañías</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('formas_pago')? 'active': ''}}"><a href="{{route('formas_pago.index')}}">
                        <i class="fas fa-comment-dollar"></i> Formas de Pago</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('presentaciones_producto')? 'active': ''}}"><a href="{{route('presentaciones_producto.index')}}">
                        <i class="fa fa-table"></i>Grupo de Producto</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador|Encargado')
                <li class="{{request()->is('marcas')? 'active': ''}}"><a href="{{route('marcas.index')}}">
                        <i class="fab fa-buysellads"></i> Marcas</a>
                </li>
                @endrole


                @role('Super-Administrador|Administrador|Encargado')
                <li class="{{request()->is('modelos')? 'active': ''}}"><a href="{{route('modelos.index')}}">
                        <i class="fas fa-tag"></i> Modelos</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('productos')? 'active': ''}}"><a href="{{route('productos.index')}}">
                        <i class="fas fa-mobile-alt"></i> Productos</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('comprasimei')? 'active': ''}}"><a href="{{route('compras.indeximei')}}">
                        <i class="fas fa-sms"></i> IMEI de Productos</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('proveedores')? 'active': ''}}">
                    <a href="{{route('proveedores.index')}}">
                        <i class="fas fa-users-cog"></i> Proveedores</a>
                </li>
                @endrole

                
            </ul>

        </li>
        @endrole

        @role('Super-Administrador|Administrador|Encargado')
        <li class="{{request()->is('compras')? 'active': ''}}">
            <a href="{{route('compras.index')}}">
                <i class="fas fa-cart-plus"></i>
                <span>&nbsp Compras</span>
            </a>
        </li>
        @endrole


        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="{{request()->is('pedidos')? 'active': ''}}">
            <a href="{{route('pedidos.index')}}">
                <i class="fas fa-cash-register"></i>
                <span>&nbsp Ventas</span>
            </a>
        </li>
        @endrole

        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="{{request()->is('recargas')? 'active': ''}}">
            <a href="{{route('recargas.index')}}">
                <i class="fas fa-tty"></i>
                <span>&nbsp Saldo de Recargas</span>
            </a>
        </li>
        @endrole


        <!-- @role('Super-Administrador|Administrador|Vendedor')
        <li class="{{request()->is('notas_envio')? 'active': ''}}"><a href="{{route('notas_envio.index')}}">
                <i class="fas fa-share-square"></i>
                <span>&nbsp Notas de Envío</span>
            </a>
        </li>
        @endrole -->
       

        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="treeview {{request()->is('bodegas*')? 'active': ''}}">
            <a href="#"><i class="fa fa-warehouse"></i> <span>Bodegas y Tiendas</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">
                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('bodegas')? 'active': ''}}"><a href="{{route('bodegas.index')}}">
                        <i class="fas fa-boxes"></i> Bodegas</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('bodegamaxmin')? 'active': ''}}"><a href="{{route('bodegamaxmin.index')}}">
                        <i class="fas fa-tag"></i> Máximos y Mínimos</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('tiendas')? 'active': ''}}"><a href="{{route('tiendas.index')}}">
                        <i class="fas fa-store"></i> Tiendas</a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('traspasos_bodega')? 'active': ''}}">
                    <a href="{{route('traspasos_bodega.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Traspasos de Bodegas</span>
                    </a>
                </li>
                @endrole


            </ul>
        </li>
        @endrole


        <!-- @role('Super-Administrador|Administrador')
        <li class="{{request()->is('partidas_ajuste')? 'active': ''}}">
            <a href="{{route('partidas_ajuste.index')}}">
                <i class="fas fa-exchange-alt fa-rotate-90"></i>
                <span>&nbsp Partidas de Ajuste</span>
            </a>
        </li>
        @endrole


        @role('Super-Administrador|Administrador|Vendedor')
        <li class="{{request()->is('cuentas_cobrar')? 'active': ''}}">
            <a href="{{route('cuentas_cobrar.index')}}">
                <i class="fas fa-hand-holding-usd"></i>
                <span>&nbsp Cuentas por Cobrar</span>
            </a>
        </li>
        @endrole

        @role('Super-Administrador|Administrador')
        <li class="{{request()->is('cuentas_pagar')? 'active': ''}}">
            <a href="{{route('cuentas_pagar.index')}}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>&nbsp Cuentas por Pagar</span>
            </a>
        </li>
        @endrole

        @role('Super-Administrador|Administrador|Vendedor')
        <li class="{{request()->is('visitas')? 'active': ''}}"><a href="{{route('visitas.index')}}">
                <i class="fas fa-check-double"></i>
                <span>&nbsp Registro de Visitas</span>
            </a>
        </li>
        <li>
            <a href="#" data-toggle="modal" data-target="#modal_ventas"><i class="fa fa-file-alt"></i>Ventas por Vendedor</a>
        </li>
        @endrole -->


        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="treeview {{request()->is('facturas*')? 'active': ''}}">
            <a href="#"><i class="fa fa-receipt"></i> <span>Facturas</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">

                <li class="{{request()->is('facturas')? 'active': ''}}">
                    <a href="{{route('facturas.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Ventas por factura</span>
                    </a>
                </li>

            </ul>
        </li>
        @endrole


        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="treeview {{request()->is('gastos*')? 'active': ''}}">
            <a href="#"><i class="fa fa-receipt"></i> <span>Gastos</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">
            @role('Super-Administrador|Administrador')
                <li class="{{request()->is('rubro_gasto')? 'active': ''}}">
                    <a href="{{route('rubro_gasto.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Rubro de Gastos</span>
                    </a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('gastos')? 'active': ''}}">
                    <a href="{{route('gastos.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Registro de Gastos</span>
                    </a>
                </li>
                @endrole

            </ul>
        </li>
        @endrole

        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="treeview {{request()->is('bancos*')? 'active': ''}}">
            <a href="#"><i class="fa fa-receipt"></i> <span>Control de Bancos</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">

                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('bancos')? 'active': ''}}">
                    <a href="{{route('bancos.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Bancos</span>
                    </a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('bancostiendas')? 'active': ''}}">
                    <a href="{{route('bancostiendas.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Asignar Banco a Tienda</span>
                    </a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('transacciones')? 'active': ''}}">
                    <a href="{{route('transacciones.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Transacción Bancaria</span>
                    </a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('traslados_bancos')? 'active': ''}}">
                    <a href="{{route('traslados_bancos.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Traslado de Dinero</span>
                    </a>
                </li>
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('saldos_bancos')? 'active': ''}}">
                    <a href="{{route('saldos_bancos.index')}}">
                        <i class="fas fa-table"></i>
                        <span>&nbsp Saldos de Bancos</span>
                    </a>
                </li>
                @endrole

            </ul>
        </li>
        @endrole


        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="treeview">
            <a href="#"><i class="fa fa-chart-line"></i><span>Reportes</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              
                @role('Super-Administrador|Administrador')
                <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_compras_fecha')}}"> 
                    <i class="fa fa-file-alt"></i>Compras por Rango Fecha </a>
                </li>  
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_traspasos_bodegas')}}"> 
                    <i class="fa fa-file-alt"></i>Traspasos entre Bodegas </a>
                </li>
                @endrole
                
                @role('Super-Administrador|Administrador|Encargado')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_ventas_imei')}}"> 
                        <i class="fa fa-file-alt"></i>Ventas por Producto e Imei </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador|Encargado')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_listado_imei')}}"> 
                        <i class="fa fa-file-alt"></i>Listado Teléfonos en Bodega </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_ventas_fecha_tienda')}}"> 
                        <i class="fa fa-file-alt"></i>Ventas por Tienda y Fecha </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador|Encargado|Vendedor')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_corte_caja')}}"> 
                        <i class="fa fa-file-alt"></i>Corte Caja </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador')

                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_listado_gastos_fecha')}}"> 
                        <i class="fa fa-file-alt"></i>Detalle de Gastos por Fecha </a>
                    </li>                  
                @endrole

                @role('Super-Administrador|Administrador')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_ventas_totales_tienda')}}"> 
                        <i class="fa fa-file-alt"></i>Ventas Totales por Tienda </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_precio_compra_producto')}}"> 
                        <i class="fa fa-file-alt"></i>Precios de Compra Producto  </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_inventario_general_costos')}}"> 
                        <i class="fa fa-file-alt"></i>Inventario General Costos  </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador|Vendedor')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_ventas_usuario')}}"> 
                        <i class="fa fa-file-alt"></i>Ventas por Usuario y Fechas  </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_movimientos_productos')}}"> 
                        <i class="fa fa-file-alt"></i>Movimientos de Producto </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador|Vendedor')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_movimientos_bancarios')}}"> 
                        <i class="fa fa-file-alt"></i>Movimientos Bancarios </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('reportes.rpt_proyecciones')}}"> 
                        <i class="fa fa-file-alt"></i>Proyecciones </a>
                    </li>  
                @endrole

                @role('Super-Administrador|Administrador')
                    <li class="{{request()->is('reportes')? 'active': ''}}"><a href="{{route('dashboard')}}"> 
                        <i class="fa fa-file-alt"></i>Cuadre de Inventario </a>
                    </li>  
                @endrole

            </ul>

            
        </li>
        @endrole



        @role('Super-Administrador|Administrador|Encargado|Vendedor')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-users"></i> <span>Gestion Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              @role('Super-Administrador|Administrador')
            <li class="{{request()->is('users')? 'active': ''}}"><a href="{{route('users.index')}}">
              <i class="fa fa-eye"></i>Usuarios</a>
            </li>
            @endrole
            @role('Super-Administrador|Administrador|Encargado|Vendedor')
            <li>
                <a href="#" data-toggle="modal" data-target="#modalResetPassword"><i class="fa fa-lock-open"></i>Cambiar contraseña</a>
            </li>
            @endrole

            @role('Super-Administrador|Administrador')
                <li class="{{request()->is('usuario_tienda')? 'active': ''}}"><a href="{{route('usuario_tienda.index')}}">
                        <i class="fas fa-user-tag"></i> Asigna Usuario a Tienda</a>
                </li>
            @endrole

          </ul>
        </li>
        @endrole


        @role('Super-Administrador')

        <li class="treeview {{request()->is('negocio*')? 'active': ''}}">
            <a href="#"><i class="fa fa-building"></i> <span>Mi Negocio</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">
                <li class="{{request()->routeIs('negocio.edit')? 'active': ''}}"><a href="{{route('negocio.edit', 1)}}">
                        <i class="fa fa-edit"></i>Editar Mi Negocio</a>
                </li>
            </ul>
        </li>
        @endrole


    </ul>

    <!-- /.sidebar-menu -->
