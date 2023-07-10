<?php

use yii\helpers\Html; 
    if(\Yii::$app->session->isActive){
                            
    
    $usu_id = Yii::$app->session->get('usu_id');
    $isAdmin = Yii::$app->session->get('usu_tipo_usuario');
    }

    $this->title = 'Mis Sugerencias';
?>

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col">
            <i class="fa-solid fa-circle-info text-warning info" data-bs-toggle="tooltip" data-bs-placement="top" title="Sugiere libros que te gustaria que sean agregados a la biblioteca"></i>
        </div>
        <div class="col-auto justify-content-end">
            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevaSugerencia'>Nueva sugerencia</button>
        </div>
    </div>

    <table id="tablaSugerencias" class="display compact">
        <thead>
            <tr>
                <th>Sugerencia</th>
                <th>Estado</th>
               
                <th>Fecha</th>
                
            </tr>
        </thead>
    </table>

    <div id="modalRevisarSugerencia" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Revisar sugerencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['sugerencias/update'], 'post') ?>
                <input type="hidden" name="id" id="idSugerenciaRevisar"></input>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col">
                                <p>¿Desea marcar como revisada la sugerencia?</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalRevisarSugerencia').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Marcar como revisada</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <div id="modalNuevaSugerencia" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva sugerencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['sugerencias/create'], 'post') ?>
                <input type="hidden" name="id" id="idSugerenciaRevisar"></input>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-3 text-end">
                                <label>Sugerencia:<span class="text-danger">*<span></label>
                            </div>
                            <div class="col">
                                <textarea class="form-control" name="sugerencia" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalNuevaSugerencia').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#tablaSugerencias').DataTable({
            language: {
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
            data: <?= $sugerencias ?>,
            responsive: true,
            bFilter: false,
            paging: false,
            ordering: false,
            columns: [{
                    data: 'sug_sugerencia'
                },
                {
                    data: function(data) {
                        if (data.sug_vigente == 'S') {
                            return "Activa";
                        } else {
                            return "Revisada";
                        }
                    }
                },
                
                {
                    data: function(data) {
                        fechaHora = data.sug_fecha_hora.split(" ");
                        fecha = fechaHora[0].split("-");
                        return fecha[2] + "/" + fecha[1] + "/" + fecha[0] + " " + fechaHora[1];
                    }
                }
            ],
        });
    });



   
</script>