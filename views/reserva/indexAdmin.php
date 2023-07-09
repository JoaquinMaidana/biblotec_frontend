<?php


use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Reservas';
?>
<style>
    #tablaLibros_filter {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="row mt-3 align-items-center">
        <div class="col-1">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <table id="tablaLibros" class="row-border items table table-condensed hover nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID libro</th>
                        <th>Documento</th>
                        <th>Estado</th>
                        <th>Creacion</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th></th>
                    </tr>
                    <tr id="filtros">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <?= Html::beginForm(['reserva/update'], 'post', ['id' => 'formReservaUpdate']) ?>
    <input type="hidden" name="id_reserva" id="idReserva"></input>
    <input type="hidden" name="libro_id" id="libro_id"></input>
    <input type="hidden" name="estado" id="estado"></input>
    <input type="hidden" name="fecha_desde" id="fecha_desde"></input>
    <input type="hidden" name="fecha_hasta" id="fecha_hasta"></input>
    <input type="hidden" name="vuelta" id="vuelta"></input>
    <?= Html::endForm() ?>
</div>

<script>
    $(document).ready(function() {







        var table = $('#tablaLibros').DataTable({
            data: <?= $reservas ?>,
            responsive: true,
            searching: true,
            bFilter: false,
            paging: false,
            ordering: false,
            language: {
                "sFilter": "Filtrar",
                "sEmptyTable": "No hay datos disponibles en la tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing": "Procesando...",
                "sSearch": "Buscar:",
                "sZeroRecords": "No se encontraron resultados",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            columns: [{
                    data: 'resv_id'
                },
                {
                    data: 'resv_lib_id'
                },
                {
                    data: 'usu_documento'
                },
                {
                    data: 'resv_estado',
                    render: function(data, type, row) {
                        var options = {
                            'P': 'Pendiente',
                            'X': 'Cancelada',
                            'C': 'Confirmada',
                            'L': 'Libro levantado',
                            'D': 'Completada',
                            'N': 'Libro no devuelto'
                        };

                        var select = '<select class="form-control">';
                        for (var key in options) {
                            var isSelected = (key === data) ? 'selected' : '';
                            select += '<option name="est" value="' + key + '" ' + isSelected + '>' + options[key] + '</option>';
                        }
                        select += '</select>';

                        return select;
                    }
                },
                {
                    data: 'resv_fecha_hora'
                },
                {
                    data: 'resv_fecha_desde',
                    render: function(data, type, row) {
                        return '<input type="date" class="form-control" value="' + data + '">';
                    }
                },
                {
                    data: 'resv_fecha_hasta',
                    render: function(data, type, row) {
                        return '<input type="date" class="form-control" value="' + data + '">';
                    }
                },
                {
                    data: function(data, row) {



                        return "</i></a><a class='me-2' ><i class='fa-solid fa-pencil'></i></a>"
                    }
                }
            ],
            initComplete: function() {
                columnas = [0, 1, 2, 3, 4, 5, 6];
                this.api().columns(columnas).every(function() {
                    var columna = this;
                    switch (columna.index()) {
                        case 0:
                        case 1:
                        case 2:
                            $('<input type="text" class="form-control"/>').appendTo($("#filtros").find("th").eq(columna.index())).on('keyup change', function() {
                                if (columna.search() !== this.value) {
                                    columna.search(this.value).draw();
                                }
                            });
                            break;
                        case 4:
                            $('<input type="date" class="form-control"/>').appendTo($("#filtros").find("th").eq(columna.index())).on('change', function() {
                                console.log(columna.search());
                                if (columna.search() !== this.value) {
                                    columna.search(this.value).draw();
                                }
                            });
                            break;
                    }
                });
            }
        });

        table.on('change', 'input, select', function() {
            var fila = table.row($(this).closest('tr'));
            var columna = table.column($(this).closest('td')).index();

            // Actualizar el valor de la celda en la tabla
            table.cell(fila, columna).data($(this).val());

            // Volver a dibujar la tabla para reflejar los cambios
            table.draw();
        });


        $('#tablaLibros').on('click', 'a.me-2', function() {
            var rowData = table.row($(this).closest('tr')).data();
            var rowIndex = table.row($(this).closest('tr')).index();
            console.log('Data:', rowData);

            update(rowData);

            console.log('Row index:', rowIndex);

        });



    });

    function desactivarLibro(id, titulo) {

        $("#idLibroDesactivar").val(id);
        $("#textoModalDesactivar").empty();
        $("#textoModalDesactivar").append("<p>¿Desea desactivar el libro " + titulo + "?</p>");
        $("#modalDesactivarLibro").modal("show");
    }

    function update(rowData) {
        console.log(rowData)
        console.log(rowData.resv_id)
        $('#idReserva').val(rowData.resv_id);
        $('#libro_id').val(rowData.resv_lib_id);
        $('#estado').val(rowData.resv_estado);
        $('#fecha_hasta').val(rowData.resv_fecha_hasta);
        $('#fecha_desde').val(rowData.resv_fecha_desde);
        $('#formReservaUpdate').submit();

    }
</script>