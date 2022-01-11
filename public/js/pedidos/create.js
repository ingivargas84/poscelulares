$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");



var validator = $('#PedidoFormContado').validate({
    onkeyup: false,
    ignore: [],
    rules: {
        nit: {
            required: true
        },
        nombre: {
            required: true
        },
        forma_pago_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        nit: {
            required: "Debe ingresar un NIT del Cliente"
        },
        nombre: {
            required: "Debe ingresar Nombre del Cliente"
        },
        forma_pago_id: {
            required: "Debe seleccionar una forma de pago"
        },
    }
});
