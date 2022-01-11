@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Movimientos de Producto
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptMovimientoProductoForm"  action="{{route('reportes.pdf_movimientos_productos')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="imei">IMEI:</label>
                                <input type="text" class="form-control" placeholder="IMEI:" name="imei" id="imei" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptMovimientoProducto" class="btn btn-success form-button" >Generar PDF</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush


@push('scripts')

<script>


$.validator.addMethod("largoImei", function(value, element) {
    var valid = false;

    var imei = $("#imei").val();

    var largo = imei.length;

    if (largo == 15)
    {
        valid = true;
    }
    else
    {
        valid = false;
    }
   
    return valid;
}, "El IMEI no posee 15 digitos");


var validator = $('#RptMovimientoProductoForm').validate({
    onkeyup: false,
    ignore: [],
    rules: {
        imei: {
            required: true,
            largoImei: true
        }
    },
    messages: {
        imei: {
            required: "Debe ingresar un número IMEI"
        },
    }
});

    


</script>


@endpush
