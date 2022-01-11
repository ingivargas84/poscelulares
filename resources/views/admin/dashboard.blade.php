@extends('admin.layoutadmin')

@section('content')
<style>
    .head {
        padding: 10px;
    }

    table {
        border-radius: 10px;
        padding: 10px;
        width: 100%;
        margin-bottom: 7px;
        color: black;
    }

    #datos, #datos td  {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 16px;
        text-align: center;
    }
</style>
<h1>Bienvenido!</h1>

@role('Super-Administrador|Administrador')

{{-- info cards --}}
  <div class="row">
    <div class="col-md-4 col-xs-6">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fas fa-cash-register"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Ventas Hoy</span>
        <span class="info-box-number">Q. {{$ventas}}</span>
      </div>
    </div>
    </div>

  <div class="col-md-4 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="ion ion-android-cart"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Compras Hoy</span>
      <span class="info-box-number">Q. {{$compras}}</span>
    </div>
  </div>
  </div>

  <div class="col-md-4 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-purple"><i class="fas fa-search-dollar"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Gastos Hoy</span>
      <span class="info-box-number">Q. {{$gastos}}</span>
    </div>
  </div>
  </div>
  </div>

  <div class="row">
    
  <div class="col-md-4 col-xs-6">
    <div class="info-box">
      <span class="info-box-icon bg-blue"><i class="fas fa-hand-holding-usd"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Ganancias Hoy</span>
        <span class="info-box-number">Q.00.00</span>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-xs-6">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fas fa-file-invoice-dollar"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Facturación Hoy</span>
        <span class="info-box-number">Q.00.00</span>
      </div>
    </div>
  </div>

  <?php $total = 0; ?>
  @foreach ($inversion as $inv)
  <?php
    $total = $total + ($inv->existencias * $inv->precio);
  ?>
  @endforeach

  <div class="col-md-4 col-xs-6">
    <div class="info-box">
      <span class="info-box-icon bg-orange"><i class="fas fa-piggy-bank"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total de Inversión</span>
        <span class="info-box-number">Q. <?php echo number_format($total, 2, ".", ","); ?></span>
      </div>
    </div>
  </div>
  

  </div>



{{-- sales chart --}}
<div class="row">
  <div class="col-sm-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Ventas diarias del mes</h3>
        <div class="box-tools pull-right">
          <h4 style="margin: 0"><span class="label label-success" id="sales_month_label"></span></h4>
        </div>
      </div>
      <div class="box-body">
        <div id="sales-graph" style="height: 175px;"></div>
      </div>
    </div>
  </div>
</div>

{{-- purchase chart --}}
<div class="row">
  <div class="col-sm-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Compras diarias del mes</h3>
        <div class="box-tools pull-right">
          <h4 style="margin: 0"><span class="label label-warning" id="purchase_month_label"></span></h4>
        </div>
      </div>
      <div class="box-body">
        <div id="purchase-graph" style="height: 175px;"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Productos Más Vendidos en el mes</u></strong>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Producto</th>
												<th>Cantidad</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($top5_prods as $t5p)
											<tr>
												<td> {{$t5p->descripcion}} </td>
												<td> {{$t5p->total}} </td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
            </div>


            <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Gráfica Top-10 Productos Vendidos</u></strong>
							</div>
							<div class="panel-body">
								
							</div>
						</div>
            </div>
</div>


<div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Alerta de Stock Mínimo</u></strong>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
                  <thead>
											<tr>
                        <th>Bodega</th>
												<th>Producto</th>
												<th>Existencias</th>
											</tr>
										</thead>
										<tbody>
											<!-- @foreach ($stockmin as $t5p)
											<tr>
												<td> {{$t5p->descripcion}} </td>
												<td> {{$t5p->total}} </td>
											</tr>
											@endforeach -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
            </div>


            <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Alerta de Stock Máximo</u></strong>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
                  <thead>
											<tr>
                        <th>Bodega</th>
												<th>Producto</th>
												<th>Existencias</th>
											</tr>
										</thead>
										<tbody>
											<!-- @foreach ($stockmin as $t5p)
											<tr>
												<td> {{$t5p->descripcion}} </td>
												<td> {{$t5p->total}} </td>
											</tr>
											@endforeach -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
            </div>
</div>

<script defer>

$(document).ready(function(){
  var date = new Date();
  var month = date.toLocaleDateString('es-ES', {month: 'long'});
  var sales_url = "{{ route('dashboard.salesData') }}";
  var purchase_url = "{{ route('dashboard.purchaseData') }}";

  $('#sales_month_label').text(month);
  $('#purchase_month_label').text(month);


$.ajax({
  type: "GET",
  headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
  url: sales_url,
  dataType: 'json',
  success: function(data){
    for (let i = 0; i < data.length; i++) {
      var newDate = new Date(data[i].date.replace(/-/g, '\/'));
      data[i].date = newDate.toLocaleDateString('es-ES', {day: 'numeric', month: 'long'});
    }

    for (let i = 0; i < data.length; i++) {
      data[i].amount = parseInt(data[i].amount).toFixed(2);
    }

    new Morris.Bar({
      element: 'sales-graph',
      data: data,
      xkey: 'date',
      ykeys: ['amount'],
      labels: ['Vendido'],
      resize: true,
      preUnits: 'Q. ',
      barColors: ['#00a65a'],
      hideHover: true,
    });
  },
  error: function(){
    console.log('error al obtener datos de ventas');
  }
});



$.ajax({
  type: "GET",
  headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
  url: purchase_url,
  dataType: 'json',
  success: function(data){

    for (let i = 0; i < data.length; i++) {
      var newDate = new Date(data[i].date.replace(/-/g, '\/'));
      data[i].date = newDate.toLocaleDateString('es-ES', {day: 'numeric', month: 'long'});
    }

    for (let i = 0; i < data.length; i++) {
      data[i].amount = parseFloat(data[i].amount).toFixed(2);
    }

    new Morris.Bar({
      element: 'purchase-graph',
      data: data,
      xkey: 'date',
      ykeys: ['amount'],
      labels: ['Comprado'],
      resize: true,
      preUnits: 'Q. ',
      barColors: ['#f39c12'],
      hideHover: true,
    });
  },
  error: function(){
    console.log('error al obtener datos de compras');
  }
});



});

</script>

@endrole

@role('Encargado')

{{-- info cards --}}
<div class="row">
    <div class="col-md-4 col-xs-6">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fas fa-cash-register"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Ventas Hoy</span>
        <span class="info-box-number">Q. {{$ventas}}</span>
      </div>
    </div>
    </div>

  <div class="col-md-4 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="ion ion-android-cart"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Compras Hoy</span>
      <span class="info-box-number">Q. {{$compras}}</span>
    </div>
  </div>
  </div>

  <div class="col-md-4 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-purple"><i class="fas fa-search-dollar"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Gastos Hoy</span>
      <span class="info-box-number">Q. {{$gastos}}</span>
    </div>
  </div>
  </div>
  </div>

{{-- sales chart --}}
<div class="row">
  <div class="col-sm-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Ventas diarias del mes</h3>
        <div class="box-tools pull-right">
          <h4 style="margin: 0"><span class="label label-success" id="sales_month_label"></span></h4>
        </div>
      </div>
      <div class="box-body">
        <div id="sales-graph" style="height: 175px;"></div>
      </div>
    </div>
  </div>
</div>

{{-- purchase chart --}}
<div class="row">
  <div class="col-sm-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Compras diarias del mes</h3>
        <div class="box-tools pull-right">
          <h4 style="margin: 0"><span class="label label-warning" id="purchase_month_label"></span></h4>
        </div>
      </div>
      <div class="box-body">
        <div id="purchase-graph" style="height: 175px;"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Productos Más Vendidos en el Mes</u></strong>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Producto</th>
												<th>Cantidad</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($top5_prods as $t5p)
											<tr>
												<td> {{$t5p->descripcion}} </td>
												<td> {{$t5p->total}} </td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
            </div>


            <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Gráfica Top-10 Productos Vendidos</u></strong>
							</div>
							<div class="panel-body">
								
							</div>
						</div>
            </div>
</div>


<div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Alerta de Stock Mínimo</u></strong>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
                        <th>Bodega</th>
												<th>Producto</th>
												<th>Existencias</th>
											</tr>
										</thead>
										<tbody>
											<!-- @foreach ($stockmin as $t5p)
											<tr>
												<td> {{$t5p->descripcion}} </td>
												<td> {{$t5p->total}} </td>
											</tr>
											@endforeach -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
            </div>


            <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Alerta de Stock Máximo</u></strong>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
                        <th>Bodega</th>
												<th>Producto</th>
												<th>Existencias</th>
											</tr>
										</thead>
										<tbody>
											<!-- @foreach ($stockmin as $t5p)
											<tr>
												<td> {{$t5p->descripcion}} </td>
												<td> {{$t5p->total}} </td>
											</tr>
											@endforeach -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
            </div>
</div>

<script>

$(document).ready(function(){
  var date = new Date();
  var month = date.toLocaleDateString('es-ES', {month: 'long'});
  var sales_url = "{{ route('dashboard.salesData') }}";
  var purchase_url = "{{ route('dashboard.purchaseData') }}";

  $('#sales_month_label').text(month);
  $('#purchase_month_label').text(month);


$.ajax({
  type: "GET",
  headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
  url: sales_url,
  dataType: 'json',
  success: function(data){
    for (let i = 0; i < data.length; i++) {
      var newDate = new Date(data[i].date.replace(/-/g, '\/'));
      data[i].date = newDate.toLocaleDateString('es-ES', {day: 'numeric', month: 'long'});
    }

    for (let i = 0; i < data.length; i++) {
      data[i].amount = parseInt(data[i].amount).toFixed(2);
    }

    new Morris.Bar({
      element: 'sales-graph',
      data: data,
      xkey: 'date',
      ykeys: ['amount'],
      labels: ['Vendido'],
      resize: true,
      preUnits: 'Q. ',
      barColors: ['#00a65a'],
      hideHover: true,
    });
  },
  error: function(){
    console.log('error al obtener datos de ventas');
  }
});



$.ajax({
  type: "GET",
  headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
  url: purchase_url,
  dataType: 'json',
  success: function(data){

    for (let i = 0; i < data.length; i++) {
      var newDate = new Date(data[i].date.replace(/-/g, '\/'));
      data[i].date = newDate.toLocaleDateString('es-ES', {day: 'numeric', month: 'long'});
    }

    for (let i = 0; i < data.length; i++) {
      data[i].amount = parseFloat(data[i].amount).toFixed(2);
    }

    new Morris.Bar({
      element: 'purchase-graph',
      data: data,
      xkey: 'date',
      ykeys: ['amount'],
      labels: ['Comprado'],
      resize: true,
      preUnits: 'Q. ',
      barColors: ['#f39c12'],
      hideHover: true,
    });
  },
  error: function(){
    console.log('error al obtener datos de compras');
  }
});




});

</script>

@endrole


@role('Vendedor')

{{-- info cards --}}
<div class="row">
    <div class="col-md-6 col-xs-6">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fas fa-cash-register"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Ventas Hoy</span>
        <span class="info-box-number">Q. {{$ventas}}</span>
      </div>
    </div>
    </div>

  <div class="col-md-6 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-purple"><i class="fas fa-search-dollar"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Gastos Hoy</span>
      <span class="info-box-number">Q. {{$gastos}}</span>
    </div>
  </div>
  </div>
  </div>

{{-- sales chart --}}
<div class="row">
  <div class="col-sm-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Ventas diarias del mes</h3>
        <div class="box-tools pull-right">
          <h4 style="margin: 0"><span class="label label-success" id="sales_month_label"></span></h4>
        </div>
      </div>
      <div class="box-body">
        <div id="sales-graph" style="height: 175px;"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Productos Más Vendidos en el Mes</u></strong>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Producto</th>
												<th>Cantidad</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($top5_prods as $t5p)
											<tr>
												<td> {{$t5p->descripcion}} </td>
												<td> {{$t5p->total}} </td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
            </div>


            <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Gráfica Top-10 Productos Vendidos</u></strong>
							</div>
							<div class="panel-body">
								
							</div>
						</div>
            </div>
</div>


<div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<strong><u>Alerta de Stock Mínimo</u></strong>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
                  <thead>
											<tr>
                        <th>Bodega</th>
												<th>Producto</th>
												<th>Existencias</th>
											</tr>
										</thead>
										<tbody>
											<!-- @foreach ($stockmin as $t5p)
											<tr>
												<td> {{$t5p->descripcion}} </td>
												<td> {{$t5p->total}} </td>
											</tr>
											@endforeach -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
            </div>


            <div class="col-md-6 col-sm-12 col-xs-12">
						
            </div>
</div>

<script>

$(document).ready(function(){
  var date = new Date();
  var month = date.toLocaleDateString('es-ES', {month: 'long'});
  var sales_url = "{{ route('dashboard.salesData') }}";
  var abonos_url = "{{ route('dashboard.abonoData') }}";

  $('#sales_month_label').text(month);
  $('#abonos_month_label').text(month);

$.ajax({
  type: "GET",
  headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
  url: sales_url,
  dataType: 'json',
  success: function(data){
    for (let i = 0; i < data.length; i++) {
      var newDate = new Date(data[i].date.replace(/-/g, '\/'));
      data[i].date = newDate.toLocaleDateString('es-ES', {day: 'numeric', month: 'long'});
    }

    for (let i = 0; i < data.length; i++) {
      data[i].amount = parseInt(data[i].amount).toFixed(2);
    }

    new Morris.Bar({
      element: 'sales-graph',
      data: data,
      xkey: 'date',
      ykeys: ['amount'],
      labels: ['Vendido'],
      resize: true,
      preUnits: 'Q. ',
      barColors: ['#00a65a'],
      hideHover: true,
    });
  },
  error: function(){
    console.log('error al obtener datos de ventas');
  }
});



$.ajax({
  type: "GET",
  headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
  url: purchase_url,
  dataType: 'json',
  success: function(data){

    for (let i = 0; i < data.length; i++) {
      var newDate = new Date(data[i].date.replace(/-/g, '\/'));
      data[i].date = newDate.toLocaleDateString('es-ES', {day: 'numeric', month: 'long'});
    }

    for (let i = 0; i < data.length; i++) {
      data[i].amount = parseFloat(data[i].amount).toFixed(2);
    }

    new Morris.Bar({
      element: 'purchase-graph',
      data: data,
      xkey: 'date',
      ykeys: ['amount'],
      labels: ['Comprado'],
      resize: true,
      preUnits: 'Q. ',
      barColors: ['#f39c12'],
      hideHover: true,
    });
  },
  error: function(){
    console.log('error al obtener datos de compras');
  }
});



});

</script>

@endrole

@stop
