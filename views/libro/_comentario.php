<?php 
if (Yii::$app->session->isActive) {      
        $isAdmin = Yii::$app->session->get('usu_tipo_usuario');   
        $usu_id = Yii::$app->session->get('usu_id');          
    }
    

 if ($padre !== null) {
    $fecha2 = date("d-m-Y H:i:s", strtotime($fecha));
    ?>
    <div class="container-fluid" id="<? $padre ?>">
    
    <?php } else {
        $fecha2 = date("d-m-Y H:i:s", strtotime($fecha));
        
        ?>
        <div class="container-fluid">
        <?php } ?>
        <div class="row">
            <div class="col pe-0">
                <div class="card">
                    <div class="card-header">
                        <?= $fecha2 ?>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?= $comentario ?></p>
                            <footer class="blockquote-footer"><?php echo "Nombre:".$documento ?></footer>
                        </blockquote>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <div class="row justify-content-start">
                                    <a class="" onclick="ocultarMostrarComentarios('<?= $id ?>')"><i id="btn<?= $id ?>" class="fa-solid fa-arrow-up-long"></i></a>
                                </div>
                            </div>
                            <?php if (isset($isAdmin)) { ?> 
                            <div class="col-6">
                                <div class="row justify-content-end">
                                    <div class="col-auto pe-0">
                                        <button class="btn btn-primary" onclick="$('#modalResponderComentario').modal('show');$('#comentarioResponder').val('<?= $comentario ?>');$('#idComentarioPadre').val('<?= $id ?>');$('#idComentarioReferencia').val('<?=  $referencia !== null ? $referencia : $id ?>')">Responder</button><!-- Cuando el comentario no es del usuario -->
                                    </div>
                                    <?php if ($usu_id == $usuario) { ?> 
                                        <div class="col-auto pe-0">
                                            <button class="btn btn-primary" onclick="$('#modalEditarComentario').modal('show');$('#idComentario').val(<?= $id ?>);$('#comentarioEditar').val('<?= $comentario ?>')">Editar</button> <!-- Cuando el comentario es del usuario -->
                                        </div>
                                        <div class="col-auto pe-0">
                                        <button class="btn btn-primary" onclick="$('#modalEliminarComentario').modal('show');$('#idComentarioEliminar').val(<?= $id ?>);$('#idComentarioPadre2').val('<?= $id ?>');$('#idComentarioReferencia2').val('<?= $referencia ?>');$('#coment').val('<?= $comentario ?>')">Eliminar</button> <!-- Cuando el comentario es del usuario -->
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php }?> 
                        </div>
                    </div>
                </div>

                <?php foreach ($hijos as $hijo) { ?>
                    <div class="mt-2">
                        <?= $this->render('_comentario', array('documento' => $hijo['usu_nombre'],'comentario' => $hijo['comet_comentario'], 'usuario' => $hijo['comet_usu'], 'fecha' => $hijo['comet_fecha_hora'], 'hijos' => $hijo['comentariosHijos'], 'id' => $hijo['comet_id'], 'referencia' => $hijo['comet_referencia_id'],  'padre' => $hijo['comet_padre_id'])); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        </div>

        