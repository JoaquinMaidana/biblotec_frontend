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
                            
                            <th>Activo</th>
                            <th>Habilitado</th>
                          
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
                 
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="text" id="editarId" name="id">
                            <div class="row justify-content-center">
                                <div class="col-3 text-end">
                                    <label>Tipo:<span class="text-danger">*<span></label>
                                </div>
                                <div class="col">
                                    <select name="tipo" id="editarTipo" type="text" class="form-control" required>
                                        <option value="1">Administrador</option>
                                        <option value="0">Estudiante</option>
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
                            <div class="row justify-content-center">
                                <div class="col">
                                    <label>Motivo</label>
                                    <textarea class="form-control" required name="motivo" ></textarea>
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

        <div id="modalActivarUsuario" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Activar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?= Html::beginForm(['usuario/activate'], 'post') ?>
                    <input type="hidden" name="id" id="idUsuarioActivar"></input>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col" id="textoModalActivar">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col">
                                    <label>Motivo</label>
                                    <textarea class="form-control" required name="motivo" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" onclick="$('#modalActivarUsuario').modal('hide');">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Activar</button>
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
                columns: [{
                        data: 'documento'
                    },
                    {
                        data: function(data) {
                            if(data.tipo_usuario==0){
                                return "Estudiante";
                            }else{
                                return "Administrador";
                            }
                        }
                    },
                    {
                        data: function(data) {
                            return "<span>" + data.nombre + " " + data.apellido + "</span>";
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
                        data: function(data) {
                            if(data.activo=='S'){
                                return "Si";
                            }else{
                                return "No";
                            }
                        }
                    },
                    {
                        data: function(data) {
                            if(data.habilitado=='S'){
                                return "Habilitado";
                            }else{
                                return "No habilitado";
                            }
                        }
                    },
                    
                    {
                        data: function(data) {

                            if(data.activo=='S'){
                                return "<a class='me-2' onclick='actualizarUsuario(" + data.documento + ")'><i class='fa-solid fa-pencil'></i></a><a class='' onclick='desactivarUsuario(" + data.id + ",`" + data.nombre + "`,`" + data.apellido + "`)'><i class='fa-solid fa-x'></i></a>"
                            }else{
                                return "<a class='me-2' onclick='actualizarUsuario(" + data.documento + ")'><i class='fa-solid fa-pencil'></i></a><a class='' onclick='activarUsuario(" + data.id + ",`" + data.nombre + "`,`" + data.apellido + "`)'><i class='fa-solid fa-check'></i></a>"
                            }
                            
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
            console.log("llega a desactivar");
        }

        function activarUsuario(id, nombre, apellido) {
            $("#idUsuarioActivar").val(id);
            $("#textoModalActivar").empty();
            $("#textoModalActivar").append("<p>¿Desea activar el usuario " + nombre + " " + apellido + "?</p>");
            $("#modalActivarUsuario").modal("show");
            console.log("llega a activar");
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
                    console.log(result); 
                  
                    var resultado = JSON.parse(result);
                    console.log("resultado es"+result);
                    console.log(resultado[0].nombre);
                    $('#editarTipo').val(resultado[0].tipo_usuario);
                    $('#editarNombre').val(resultado[0].nombre);
                    $('#editarApellido').val(resultado[0].apellido);
                    $('#editarCorreo').val(resultado[0].mail);
                    $('#editarTelefono').val(resultado[0].telefono);
                    $('#editarDocumento').val(resultado[0].documento);
                    $('#editarHabilitado').val(resultado[0].habilitado);
                    $('#editarId').val(resultado[0].id);
                    
                    $("#modalEditarUsuario").modal("show");
                },
            });
        }
    </script>