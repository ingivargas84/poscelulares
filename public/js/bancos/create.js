
var validator = $("#BancosForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        banco: {
            required: true
        }
    },
    messages: {
        banco: {
            required: 'Es un dato obligatorio',
        }
    }
});

$("#ButtonBancos").click(function (event) {
    if ($('#BancosForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonBancos");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});

