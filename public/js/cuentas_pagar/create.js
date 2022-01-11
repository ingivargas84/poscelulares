$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");

$.validator.addMethod("fecha", function (value, element) {
    var valor = value;
    var fecha = new Date(valor);

    var anio = fecha.getFullYear().toString();
    var check = anio.length;

    if (check == 4) {
        return true;
    } else {
        return false;
    }
}, "El año no puede tener más de 4 dígitos.");

var validator = $("#InsertarForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
    //    monto: {
      //      required: true,
        //    min: 1
        //},
        forma_pago: {
            select: 'default'
        },
        fecha_ingreso: {
            required: true,
            fecha: true
        },
        factura: {
            select: 'default',
        }
    },
    messages: {
        monto: {
            required: 'Por favor, ingrese el monto.',
            min: 'La cantidad a abonar debe ser mayor a 0'
        },
        fecha_ingreso: {
            required: 'Por favor, seleccione la fecha.'
        },
        factura: {
            required: 'Por favor, seleccione la factura.'
        }
    }
});

$("#btnInsertar").click(function (event) {
    if ($('#InsertarForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("btnInsertar");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
