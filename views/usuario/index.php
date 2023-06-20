<?php


use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Usuarios';
?>


<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-1">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevoUsuario'>Nuevo usuario</button>
        </div>

        <div class="row">
            <div class="col-12">
                <table id="tablaUsuarios" class="row-border items table table-condensed hover nowrap">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Tipo</th>
                            <th>Nombre y apellido</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Documento</th>
                            <th>Habilitado</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div id="modalNuevoUsuario" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?= Html::beginForm(['usuario/create'], 'post') ?>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Tipo:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <select name="tipo" type="text" class="form-control" required>
                                        <option value="1">Administrador</option>
                                        <option value="2">Cliente</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Nombre:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="nombre" type="text" class="form-control" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Apellido:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="apellido" type="text" class="form-control" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Correo:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="correo" type="email" class="form-control" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Telefono:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="telefono" type="tel" class="form-control" maxlength="10" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Documento:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="documento" type="text" class="form-control" maxlength="8" required></input>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" onclick="$('#modalNuevoUsuario').modal('hide');">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <div id="modalEditarUsuario" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?= Html::beginForm(['usuario/update'], 'post') ?>
                    <input name="id" id="editarId" type="text" class="form-control" hidden></input>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Tipo:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <select name="tipo" id="editarTipo" type="text" class="form-control" required>
                                        <option value="1">Administrador</option>
                                        <option value="2">Cliente</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Nombre:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="nombre" id="editarNombre" type="text" class="form-control" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Apellido:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="apellido" id="editarApellido" type="text" class="form-control" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Correo:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="correo" id="editarCorreo" type="email" class="form-control" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Telefono:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="telefono" id="editarTelefono" type="tel" class="form-control" maxlength="10" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Documento:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <input name="documento" id="editarDocumento" type="text" class="form-control" maxlength="8" required></input>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Habilitado:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <select name="habilitado" id="editarHabilitado" type="text" class="form-control" required>
                                        <option value="S">Si</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" onclick="$('#modalEditarUsuario').modal('hide');">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <div id="modalDesactivarUsuario" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Desactivar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?= Html::beginForm(['usuario/delete'], 'post') ?>
                    <input type="hidden" name="id" id="idUsuarioDesactivar"></input>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col" id="textoModalDesactivar">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" onclick="$('#modalDesactivarUsuario').modal('hide');">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Desactivar</button>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#tablaUsuarios').DataTable({
                data: <?= $usuarios ?>,
                responsive: true,
                bFilter: false,
                paging: false,
                ordering: false,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'tipo_usuario'
                    },
                    {
                        data: function(data) {
                            return "<span>" + data.usu_nombre + " " + data.usu_apellido + "</span>";
                        }
                    },
                    {
                        data: 'mail'
                    },
                    {
                        data: 'telefono'
                    },
                    {
                        data: 'documento'
                    },
                    {
                        data: 'habilitado'
                    },
                    {
                        data: 'usu_estado'
                    },
                    {
                        data: function(data) {
                            return "<a class='me-2' onclick='actualizarUsuario(" + data.usu_id + ")'><i class='fa-solid fa-pencil'></i></a><a class='' onclick='desactivarUsuario(" + data.usu_id + ",`" + data.usu_nombre + "`,`" + data.usu_apellido + "`)'><i class='fa-solid fa-x'></i></a>"
                        }
                    }
                ],
            });
        });

        function desactivarUsuario(id, nombre, apellido) {
            $("#idUsuarioDesactivar").val(id);
            $("#textoModalDesactivar").empty();
            $("#textoModalDesactivar").append("<p>¿Desea desactivar el usuario " + nombre + " " + apellido + "?</p>");
            $("#modalDesactivarUsuario").modal("show");
        }

        function actualizarUsuario(id) {
            $.ajax({
                method: "POST",
                url: "<?= Url::toRoute(['usuario/update']); ?>",
                data: {
                    _csrf: "<?= Yii::$app->request->csrfToken; ?>",
                    id: id,
                },
                success: function(result) {
                    console.log(result); //Rellenar los campos 
                    $("#modalEditarUsuario").modal("show");
                },
            });
        }
    </script>