
<?php


use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Libros';
?>


<div class="container-fluid">
    <div class="row mt-3 align-items-center">
        <div class="col-1">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col d-flex justify-content-end">
            <?= Html::a('Nuevo Libro', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table id="tablaLibros" class="row-border items table table-condensed hover nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Titulo</th>
                        <th>Sub Categoria</th>
                        <th>Stock</th>
                        <th>Disponible</th>
                        <th>Vigente</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <?= Html::beginForm(['libro/view'], 'post', ['id' => 'formLibroView']) ?>
    <input type="hidden" name="id" id="idLibroView"></input>
    <?= Html::endForm() ?>

    <?= Html::beginForm(['libro/update'], 'get', ['id' => 'formLibroUpdate']) ?>
    <input type="hidden" name="idlibros" id="idLibroUpdate"></input>
    <?= Html::endForm() ?>

    <div id="modalDesactivarLibro" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Desactivar libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['libro/delete'], 'post') ?>
                <input type="hidden" name="id" id="idLibroDesactivar"></input>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col" id="textoModalDesactivar">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalDesactivarLibro').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Desactivar</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalDesactivarLibro').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Desactivar</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#tablaLibros').DataTable({
            data: <?= $libros ?>,
            responsive: true,
            bFilter: false,
            paging: false,
            ordering: false,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'lib_titulo'
                },
                {
                    data: 'lib_sub_categoria'
                },
                {
                    data: 'lib_stock'
                },
                {
                    data: 'lib_disponible'
                },
                {
                    data: 'lib_vigente'
                },
                {
                    data: function(data) {
                        return "<a class='me-2' onclick='$(`#idLibroView`).val(`" + data.id + "`);$(`#formLibroView`).submit()'><i class='fa-solid fa-plus'></i></a><a class='me-2' onclick='$(`#idLibroUpdate`).val(`" + data.id + "`);$(`#formLibroUpdate`).submit()'><i class='fa-solid fa-pencil'></i></a><a class='' onclick='desactivarLibro(" + data.id + ",`" + data.lib_titulo + "`)'><i class='fa-solid fa-x'></i></a>"
                    }
                }
            ],
        $('#tablaLibros').DataTable({
            data: <?= $libros ?>,
            responsive: true,
            bFilter: false,
            paging: false,
            ordering: false,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'lib_titulo'
                },
                {
                    data: 'lib_sub_categoria'
                },
                {
                    data: 'lib_stock'
                },
                {
                    data: 'lib_disponible'
                },
                {
                    data: 'lib_vigente'
                },
                {
                    data: function(data) {
                        return "<a class='me-2' onclick='$(`#idLibroView`).val(`" + data.id + "`);$(`#formLibroView`).submit()'><i class='fa-solid fa-plus'></i></a><a class='me-2' onclick='$(`#idLibroUpdate`).val(`" + data.id + "`);$(`#formLibroUpdate`).submit()'><i class='fa-solid fa-pencil'></i></a><a class='' onclick='desactivarLibro(" + data.id + ",`" + data.lib_titulo + "`)'><i class='fa-solid fa-x'></i></a>"
                    }
                }
            ],
        });
    });

    function desactivarLibro(id, titulo) {

        $("#idLibroDesactivar").val(id);
        $("#textoModalDesactivar").empty();
        $("#textoModalDesactivar").append("<p>¿Desea desactivar el libro " + titulo + "?</p>");
        $("#modalDesactivarLibro").modal("show");
    }

    function desactivarLibro(id, titulo) {

        $("#idLibroDesactivar").val(id);
        $("#textoModalDesactivar").empty();
        $("#textoModalDesactivar").append("<p>¿Desea desactivar el libro " + titulo + "?</p>");
        $("#modalDesactivarLibro").modal("show");
    }
</script>