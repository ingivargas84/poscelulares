$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $("#FacturaForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        pedido_maestro_id: {
            select: "default"
        },
        serie_factura: {
            required: true,
        },
        no_factura: {
            required: true
        }
    },
    messages: {
        serie_factura: {
            required: 'Por favor, ingrese la serie de la factura',
        },
        no_factura: {
            required: 'Por favor, ingrese el número de la factura'
        }
    }
});
