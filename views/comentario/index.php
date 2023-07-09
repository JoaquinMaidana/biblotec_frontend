<?php


use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

    $this->title = 'Comentarios del libro ' . $tituloLibro;
    $idLibro = $comentarios[0]['comet_lib_id'];

    if (Yii::$app->session->isActive) {      
        $documento = Yii::$app->session->get('usu_documento');    
        $isAdmin = Yii::$app->session->get('usu_tipo_usuario');                
    }
        
              
    
?>


<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col text-truncate">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php if (isset($isAdmin) && ( $isAdmin ==='Estudiante' || $isAdmin==='Administrador')) { ?> 
            <div class="col-auto d-flex justify-content-end">
                <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevoComentario'>Nuevo comentario</button>
            </div>
        <?php } ?> 
    </div>
    <div class="row align-items-center">
    
        <?php foreach ($comentarios as $comentario) { ?>
            <div class="row mt-3">
                <hr>
                <div class="col-12">
                    <?= $this->render('_comentario', array('comentario' => $comentario['comet_comentario'], 'usuario' => $comentario['comet_usu'], 'fecha' => $comentario['comet_fecha_hora'], 'hijos' => $comentario['comentariosHijos'], 'id' => $comentario['comet_id'], 'referencia' => $comentario['comet_referencia_id'], 'padre' => $comentario['comet_padre_id'])); ?>
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
            <input type="hidden" name="idLibro" value='<?= $idLibro ?>'></input>
            <input type="hidden" name="comentarioPadre" id="idComentarioPadre2"></input>
            <input type="hidden" name="comentarioReferencia" id="idComentarioReferencia2"></input>
            <input type="hidden" name="comentario" value="" id="coment" >
            <input type="hidden" name="token" value="" >
            <input type="hidden" name="tituloLibro" value="<?= $tituloLibro ?>"></input>
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
            <input type="hidden" name="token" value="" >
            <input type="hidden" name="tituloLibro" value="<?= $tituloLibro ?>"></input>
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
            <input type="hidden" name="tituloLibro" value="<?= $tituloLibro ?>"></input>
            <input type="hidden" name="comentarioPadre" id="idComentarioPadre"></input>
            <input type="hidden" name="isbn" value='9781491912058'></input>
            <input type="hidden" name="comentarioReferencia" id="idComentarioReferencia"></input>
            <input type="hidden" name="token" value="" >
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
            <input type="hidden" name="token" value="" >
            <input type="hidden" name="tituloLibro" value="<?= $tituloLibro ?>"></input>
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

<script>
    function ocultarMostrarComentarios(padre){
        if($("#" + padre).is(":visible")){
            $("#btn" + padre).removeClass("fa-arrow-up-long");
            $("#btn" + padre).addClass("fa-arrow-down-long");
            $("#" + padre).hide();
        } else {
            $("#btn" + padre).addClass("fa-arrow-up-long");
            $("#btn" + padre).removeClass("fa-arrow-down-long");
            $("#" + padre).show();
        }
    }
        </script>

<script> 
        let tokenElements = document.querySelectorAll('[name="token"]');

        if (tokenElements.length > 0) {
        let token = localStorage.getItem('TokenBibliotec_<?=$documento ?>');
        if (token) {
            tokenElements.forEach(function(element) {
            element.value = token;
            });
        } else {
            console.log('El token no está disponible.');
        }
        }

</script>