<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Categorias';

if (Yii::$app->session->isActive) {      
    $documento = Yii::$app->session->get('usu_documento');             
}

?>

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-1">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevaCategoria'>Nueva categoria</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table id="tablaCategorias" class="row-border items table table-condensed hover nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Vigente</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalNuevaCategoria" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['categoria/create'], 'post') ?>
                <input type="hidden" name="token" value="" >
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-3 text-end">
                                <label>Nombre:<span class="text-danger">*<span></label>
                            </div>
                            <div class="col">
                                <input name="nombre" type="text" class="form-control" required></input>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalNuevaCategoria').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <div id="modalEditarCategoria" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['categoria/update'], 'post') ?>
                <input type="hidden" name="id" id="idCategoriaEditar"></input>
                <input type="hidden" name="token" value="" >
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-3 text-end">
                                <label>Nombre:<span class="text-danger">*<span></label>
                            </div>
                            <div class="col">
                                <input name="nombre" id="editarNombre" type="text" class="form-control" required></input>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalEditarCategoria').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Editar</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <div id="modalDesactivarCategoria" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Desactivar categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['categoria/delete'], 'post') ?>
                <input type="hidden" name="id" id="idCategoriaDesactivar"></input>
                <input type="hidden" name="token" value="" >
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col" id="textoModalDesactivar">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalDesactivarCategoria').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Desactivar</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#tablaCategorias').DataTable({
                data: <?= $categorias ?>,
                responsive: true,
                bFilter: false,
                paging: false,
                ordering: false,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: function(data) {
                            if (data.vigente == "S") {
                                return "<span>Si<span>";
                            } else {
                                return "<span>No<span>";
                            }
                        },
                    },
                    {
                        data: function(data) {
                            return "<a class='me-2' onclick='editarCategoria(" + data.id + ",`" + data.nombre + "`)'><i class='fa-solid fa-pencil'></i></a><a class='' onclick='desactivarCategoria(" + data.id + ",`" + data.nombre + "`)'><i class='fa-solid fa-x'></i></a>";
                        }
                    },
                ],
            });
        });

        function editarCategoria(id, nombre) {

            $("#idCategoriaEditar").val(id);
            $("#editarNombre").val(nombre);
            $("#modalEditarCategoria").modal("show");
        }

        function desactivarCategoria(id, nombre) {

            $("#idCategoriaDesactivar").val(id);
            $("#textoModalDesactivar").empty();
            $("#textoModalDesactivar").append("<p>¿Desea desactivar la categoria " + nombre +"?</p>");
            $("#modalDesactivarCategoria").modal("show");
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