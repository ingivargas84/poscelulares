$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción");


var validator = $("#GastosForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        rubro_gasto_id: {
            required: true,
            select: 'default'
        },
        monto: {
            required: true
        },
        descripcion: {
            required: true
        }
    },
    messages: {
        rubro_gasto_id: {
            required: 'Seleccione una opción',
        },
        monto: {
            required: 'Por favor, ingrese un monto',
        },
        descripcion: {
            required: 'Por favor, ingrese una descripcion',
        },
    }
});

$("#ButtonRubroGasto").click(function (event) {
    if ($('#GastosForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonRubroGasto");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});

