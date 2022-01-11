var saldos_bancos_table = $('#saldos_bancos-table').DataTable({
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [10, 25, 50, -1],
        ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
    ],

    "buttons": [
        'pageLength',
        {
            extend: 'excelHtml5',
            title: 'Productos',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5]
            }
        }
    ],

    "paging": true,
    "language": {
        "sdecimal": ".",
        "sthousands": ",",
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningun dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Ultimo",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [{
        "title": "#",
        "data": "id",
        "width": "5%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Tienda",
        "data": "tienda",
        "width": "20%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },


    {
        "title": "Banco",
        "data": "banco",
        "width": "15%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Saldo Electronico",
        "data": "saldo_inicial",
        "width": "10%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },


    {
        "title": "Saldo Caja",
        "data": "saldo_real",
        "width": "10%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Fecha",
        "data": "created_at",
        "width": "10%",
        "responsivePriority": 2,
        "className": "text-right",
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Acciones",
        "orderable": false,
        "width": "20%",
        "className": 'text-center',
        "render": function (data, type, full, meta) {

        if (full.saldo_inicial == full.saldo_real){
            return "<div id='" + full.id + "' class='text-center' >" +
                    "<div class='float-center col-lg-12'>" +
                    "<a href='#' class='remove-traslado' data-method='delete' data-id='" + full.id + "' data-target='#modalConfirmarAccion' data-toggle='modal'>" +
                    "<i class='fas fa-trash-alt' title='Eliminar Traslado'></i>" +
                    "</a>" + "</div>";
        }
        else
        {
            return "<div id='" + full.id + "' class='text-center' >" ;
        }
            
        },
        "responsivePriority": 5
    }]

});


$("#btnConfirmarAccion").click(function (event) {
    event.preventDefault();
    confirmarAccion();
});


function confirmarAccion(button) {
    $('.loader').fadeIn();
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
        url: APP_URL + "/traslados_bancos/" + id + "/delete",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#modalConfirmarAccion').modal("hide");
            saldos_bancos_table.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('El traslado se elimino Correctamente!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            if (errors.responseText != "") {
                var errors = JSON.parse(errors.responseText);
                if (errors.password_actual != null) {
                    $("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>" + errors.password_actual + "</label>");
                }
                else {
                    $("#ErrorPassword_actual").remove();
                }
            }

        }

    });
}


