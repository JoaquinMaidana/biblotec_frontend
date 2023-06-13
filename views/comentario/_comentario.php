<?php if ($padre != 0) { ?>
    <div class="container-fluid" id="<?= $padre ?>">
    <?php } else { ?>
        <div class="container-fluid">
        <?php } ?>
        <div class="row">
            <div class="col pe-0">
                <div class="card">
                    <div class="card-header">
                        <?= $fecha ?>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?= $comentario ?></p>
                            <footer class="blockquote-footer"><?= $usuario ?></footer>
                        </blockquote>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <div class="row justify-content-start">
                                    <a class="" onclick="ocultarMostrarComentarios('<?= $id ?>')"><i id="btn<?= $id ?>" class="fa-solid fa-arrow-up-long"></i></a>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row justify-content-end">
                                    <div class="col-auto pe-0">
                                        <button class="btn btn-primary" onclick="$('#modalResponderComentario').modal('show');$('#comentarioResponder').val('<?= $comentario ?>');$('#idComentarioPadre').val('<?= $id ?>');$('#idComentarioReferencia').val('<?= $referencia ?>')">Responder</button><!-- Cuando el comentario no es del usuario -->
                                    </div>
                                    <div class="col-auto pe-0">
                                        <button class="btn btn-primary" onclick="$('#modalEditarComentario').modal('show');$('#idComentario').val(<?= $id ?>);$('#comentarioEditar').val('<?= $comentario ?>')">Editar</button> <!-- Cuando el comentario es del usuario -->
                                    </div>
                                    <div class="col-auto pe-0">
                                        <button class="btn btn-primary" onclick="$('#modalEliminarComentario').modal('show');$('#idComentarioEliminar').val(<?= $id ?>)">Eliminar</button> <!-- Cuando el comentario es del usuario -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php foreach ($hijos as $hijo) { ?>
                    <div class="mt-2">
                        <?= $this->render('_comentario', array('comentario' => $hijo['comet_comentario'], 'usuario' => $hijo['comet_usu'], 'fecha' => $hijo['comet_fecha_hora'], 'hijos' => $hijo['comentariosHijos'], 'id' => $hijo['comet_id'], 'referencia' => $hijo['comet_referencia_id'],  'padre' => $hijo['comet_padre_id'])); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        </div>