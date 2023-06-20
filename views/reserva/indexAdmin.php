
<?php


use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Reservas';
?>


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
                        <th>Isbn</th>
                        <th>ID Usuario</th>
                        <th>Estado</th>
                        <th>Creacion</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <?= Html::beginForm(['libro/view'], 'post', ['id' => 'formLibroView']) ?>
    <input type="hidden" name="id" id="idLibroView"></input>
    <input type="hidden" name="vuelta" id="vuelta"></input>
    <?= Html::endForm() ?>

   

    

</div>

<script>
    $(document).ready(function() {
        $('#tablaLibros').DataTable({
            data: <?= $reservas ?>,
            responsive: true,
            bFilter: false,
            paging: false,
            ordering: false,
            columns: [{
                    data: 'resv_id'
                },
                {
                    data: 'isbn_libro'
                },
                {
                    data: 'resv_usu_id'
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

                    var select = '<select>';
                    for (var key in options) {
                        var isSelected = (key === data) ? 'selected' : '';
                        select += '<option value="' + key + '" ' + isSelected + '>' + options[key] + '</option>';
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
                        return '<input type="date"  value="' + data + '">';
                    }
                },
                {
                    data: 'resv_fecha_hasta',
                    render: function(data, type, row) {
                        return '<input type="date"  value="' + data + '">';
                    }
                },
                {
                    data: function(data) {
                        return "</i></a><a class='me-2' onclick='$(`#idLibroUpdate`).val(`" + data.id + "`);$(`#formLibroUpdate`).submit()'><i class='fa-solid fa-pencil'></i></a>"
                    }
                }
            ],
    });
    });
    function desactivarLibro(id, titulo) {

        $("#idLibroDesactivar").val(id);
        $("#textoModalDesactivar").empty();
        $("#textoModalDesactivar").append("<p>¿Desea desactivar el libro " + titulo + "?</p>");
        $("#modalDesactivarLibro").modal("show");
    }
</script>