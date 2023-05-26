<?php


use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Comentarios del libro ' . $tituloLibro;
$idLibro = $comentarios[0]['comet_lib_id'];
?>


<div class="container-fluid">
    <div class="row mt-3 align-items-center">
        <div class="col text-truncate">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-auto d-flex justify-content-end">
            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevoComentario'>Nuevo comentario</button>
        </div>
    </div>
    <div class="row align-items-center">
        <?php foreach ($comentarios as $comentario) { ?>
            <div class="row mt-3">
                <hr>
                <div class="col-12">
                    <?= $this->render('_comentario', array('comentario' => $comentario['comet_comentario'], 'usuario' => $comentario['comet_usu'], 'fecha' => $comentario['comet_fecha_hora'], 'hijos' => $comentario['comentariosHijos'], 'id' => $comentario['comet_id'], 'referencia' => $comentario['comet_referencia_id'])); ?>
                </div>
            </div>
        <?php } ?>
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
            <input type="hidden" name="idLibro" value='<?= $idLibro ?>'></input>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <textarea class="form-control" name="comentario" id="comentarioNuevo"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalNuevoComentario').modal('hide');">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnComentar" disabled>Comentar</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<div id="modalResponderComentario" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Responder Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= Html::beginForm(['comentario/create'], 'post') ?>
            <input type="hidden" name="idLibro" value='<?= $idLibro ?>'></input>
            <input type="hidden" name="comentarioPadre" id="idComentarioPadre"></input>
            <input type="hidden" name="comentarioReferencia" id="idComentarioReferencia"></input>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <textarea class="form-control" id="comentarioResponder" disabled></textarea>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3">
                        <div class="col">
                            <textarea class="form-control" name="comentario" id="comentarioRespuesta"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalResponderComentario').modal('hide');">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnRespuesa" disabled>Responder</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<div id="modalEditarComentario" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= Html::beginForm(['comentario/update'], 'post') ?>
            <input type="hidden" name="id" id="idComentario"></input>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <textarea class="form-control" name="comentario" id="comentarioEditar"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalEditarComentario').modal('hide');">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnEditar">Editar</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comentarioRespuesta").on("input", function() {
            if ($("#comentarioRespuesta").val() != '') {
                $("#btnRespuesa").prop("disabled", false);
            } else {
                $("#btnRespuesa").prop("disabled", true);
            }
        });

        $("#comentarioNuevo").on("input", function() {
            if ($("#comentarioNuevo").val() != '') {
                $("#btnComentar").prop("disabled", false);
            } else {
                $("#btnComentar").prop("disabled", true);
            }
        });

        $("#comentarioEditar").on("input", function() {
            if ($("#comentarioEditar").val() != '') {
                $("#btnEditar").prop("disabled", false);
            } else {
                $("#btnEditar").prop("disabled", true);
            }
        });
    });
</script>