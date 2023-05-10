<?php


use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Comentarios del libro ' . $tituloLibro;
?>


<div class="container-fluid">
    <div class="row mt-3 align-items-center">
        <div class="col-1">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevoUsuario'>Nuevo usuario</button>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- aca va todo -->
            </div>
        </div>
    </div>
</div>

<div id="modalEliminarComentario" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= Html::beginForm(['comentario/delete'], 'post') ?>
            <input type="hidden" name="id" id="idComentarioEliminar"></input>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <h5>¿Desea eliminar el comentario?</h5>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col" id="comentarioEliminar">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalEliminarComentario').modal('hide');">Cancelar</button>
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<div id="modalNuevoComentario" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Comentario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?= Html::beginForm(['comentario/create'], 'post') ?>
                    <input type="hidden" name="id" id="idComentarioEliminar"></input>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col">
                                    <h5>¿Desea eliminar el comentario?</h5>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col" id="comentarioEliminar">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" onclick="$('#modalEliminarComentario').modal('hide');">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Eliminar</button>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>



<script>
    $(document).ready(function() {});

    function eliminarComentario(id, comentario) {
        $("#idComentarioEliminar").val(id);
        $("#comentarioEliminar").empty();
        $("#comentarioEliminar").append("<textarea class='form-control' disabled>" + comentario + "</textarea>");
        $("#modalEliminarComentario").modal("show");
    }

    function actualizarComentario(id, comentario) {
        $.ajax({
            method: "POST",
            url: "<?= Url::toRoute(['usuario/update']); ?>",
            data: {
                _csrf: "<?= Yii::$app->request->csrfToken; ?>",
                id: id,
                comentario: comentario
            },
        });
    }
</script>