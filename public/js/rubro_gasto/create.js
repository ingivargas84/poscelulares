
var validator = $("#RubroGastoForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        rubro_gasto: {
            required: true
        }
    },
    messages: {
        rubro_gasto: {
            required: 'Es un dato obligatorio',
        }
    }
});

$("#ButtonRubroGasto").click(function (event) {
    if ($('#RubroGastoForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonRubroGasto");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});

