<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Subcategorias';
?>

<div class="container-fluid">
    <div class="row mt-3 align-items-center">
        <div class="col-1">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col d-flex justify-content-end">
            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevaSubcategoria'>Nueva subcategoria</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table id="tablaSubcategorias" class="row-border items table table-condensed hover nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Vigente</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalNuevaSubcategoria" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva subcategoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['subcategoria/create'], 'post') ?>

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

                        <div class="row justify-content-center mt-3">
                            <div class="col-3 text-end">
                                <label>Categoría:<span class="text-danger">*<span></label>
                            </div>
                            <div class="col">
                                <select name="categoria" type="text" class="form-control" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?= $categoria->id ?>"><?= $categoria->cat_nombre ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalNuevaSubcategoria').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <div id="modalEditarSubcategoria" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar subcategoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['subcategoria/update'], 'post') ?>

                <input type="hidden" name="id" id="idSubcategoriaEditar"></input>
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

                        <div class="row justify-content-center mt-3">
                            <div class="col-3 text-end">
                                <label>Categoría:<span class="text-danger">*<span></label>
                            </div>
                            <div class="col">
                                <select name="categoria" id="editarCategoria" type="text" class="form-control" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?= $categoria->id ?>"><?= $categoria->cat_nombre ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalEditarSubcategoria').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Editar</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <div id="modalDesactivarSubcategoria" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Desactivar subcategoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['subcategoria/delete'], 'post') ?>
                <input type="hidden" name="id" id="idSubcategoriaDesactivar"></input>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col" id="textoModalDesactivar">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalDesactivarSubcategoria').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Desactivar</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#tablaSubcategorias').DataTable({
                data: <?= $sub_categorias ?>,
                responsive: true,
                bFilter: false,
                paging: false,
                ordering: false,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'subcat_nombre'
                    },
                    {
                        data: 'subcat_cat_id'
                    },
                    {
                        data: function(data) {
                            if (data.subcat_vigente == "S") {
                                return "<span>Si<span>";
                            } else {
                                return "<span>No<span>";
                            }
                        },
                    },
                    {
                        data: function(data) {
                            return "<a class='me-2' onclick='editarSubcategoria(" + data.id + ",`" + data.subcat_nombre + "`," + data.id + ")'><i class='fa-solid fa-pencil'></i></a><a class='' onclick='desactivarSubcategoria(" + data.id + ",`" + data.subcat_nombre + "`)'><i class='fa-solid fa-x'></i></a>";
                        }
                    },
                ],
            });
        });

        function editarSubcategoria(id, nombre, categoria) {

            $("#idSubcategoriaEditar").val(id);
            $("#editarNombre").val(nombre);
            $("#editarCategoria").val(categoria);
            $("#modalEditarSubcategoria").modal("show");
        }

        function desactivarSubcategoria(id, nombre) {

            $("#idSubcategoriaDesactivar").val(id);
            $("#textoModalDesactivar").empty();
            $("#textoModalDesactivar").append("<p>¿Desea desactivar la subcategoria " + nombre + "?</p>");
            $("#modalDesactivarSubcategoria").modal("show");
        }
    </script>