$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");



$.validator.addMethod("fecha", function (value, element) {
    var valor = value;
    var fecha = new Date(valor);

    var hoy = new Date();

    var tot = hoy-fecha;

    if (tot<5) {
        return true;
    } else {
        return false;
    }
}, "No se puede registrar una compra con más de 5 días de diferencia");



var validator = $('#CompraForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        proveedor_id: {
            required: true,
            select: 'default'
        },
        serie_factura: {
            required: true
        },
        bodega_id: {
            required: true,
            select: 'default'
        },
        num_factura: {
            required: true,
            number: true,
        }

    },
    messages: {
        proveedor_id: {
            required: "Debe seleccionar un proveedor."
        },
        serie_factura: {
            required: "Este campo es obligatorio."
        },
        bodega_id: {
            required: "Este campo es obligatorio."
        },
        num_factura: {
            required: "Este campo es obligatorio.",
            number: "Este campo solo acepta valores numéricos."
        }
    }
});

