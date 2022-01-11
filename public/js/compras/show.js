var detalles_table = $('#detalles-table').DataTable({
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
    ],

    "paging": true,
    "language": {
        "sdecimal": ".",
        "sthousands": ",",
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
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
            "sLast": "Último",
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
        "title": "Producto",
        "data": "producto",
        "width": "30%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    
    {
        "title": "Cantidad",
        "data": "cantidad",
        "width": "10%",
        "responsivePriority": 4,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    
    {
        "title": "Precio de Compra",
        "data": "precio_compra",
        "width": "20%",
        "responsivePriority": 1,
        "className": "text-right",
        "render": function (data, type, full, meta) {
            return 'Q. ' + (data);
        },
    },

    {
        "title": "Subtotal",
        "data": "subtotal",
        "width": "20%",
        "responsivePriority": 1,
        "className": "text-right",
        "render": function (data, type, full, meta) {
            return 'Q. ' + (data);
        },
    },


    {
        "title": "Acciones",
        "orderable": false,
        "width": "20%",
        "className": "text-center",
        "render": function (data, type, full, meta) {

            if (full.presentacion <= 2) {
                if(full.cantidad > full.tot_imei){
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-center col-lg-6'>" +
                    "<a href='/compras/imei/" + full.id + "' class='edit-imei' >" +
                    "<i class='fas fa-mobile-alt' title='Asignar IMEI'></i>" +
                    "</a>" + "</div></div>";
                }else{
                    return "<div id='" + full.id + "' class='text-center'>" ;
                }
            }else{
                return "<div id='" + full.id + "' class='text-center'>" ;
            }
        },
        "responsivePriority": 5
    }]

});

