<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Sugerencias';
if (Yii::$app->session->isActive) {
    $documento = Yii::$app->session->get('usu_documento');
    $id_usuario =  Yii::$app->session->get('usu_id');
}
?>

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col d-flex justify-content-end pe-0">
            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevaSugerencia'>Nueva sugerencia</button>
        </div>
        <div class="col d-flex justify-content-end ps-0">
            <?= Html::a('Mis sugerencias', ['view'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <table id="tablaSugerencias" class="display compact">
        <thead>
            <tr>
                <th>Sugerencia</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th></th>
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
                    <h5 class="modal-title">Revisar sugerencia</h5>
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
            data: <?= $sugerenciasJson ?>,
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
                    data: 'sug_usu_id'
                },
                {
                    data: function(data) {
                        fechaHora = data.sug_fecha_hora.split(" ");
                        fecha = fechaHora[0].split("-");
                        return fecha[2] + "/" + fecha[1] + "/" + fecha[0] + " " + fechaHora[1];
                    }
                },
                {
                    data: function(data) {
                        if (data.sug_vigente == 'S') {
                            return "<a class='me-2' onclick='$(`#idSugerenciaRevisar`).val(`" + data.sug_id + "`);$(`#modalRevisarSugerencia`).modal(`show`)'><i class='fa-solid fa-check'></i></a>"
                        }
                    }
                }
            ],
        });
    });



    let token = localStorage.getItem('TokenBibliotec_<?= $documento ?>');
    if (token) {
        document.getElementById('token-field').value = token;
    } else {
        // El contenido de token es nulo o no existe
        // Puedes manejar esta situación según tus necesidades
        console.log('El token no está disponible.');
    }
</script>