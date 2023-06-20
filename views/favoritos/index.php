<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Libros favoritos';
?>

<style>
    .card {
        height: 100% !important;
    }

    .card button {
        width: 100%;
    }
</style>

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <hr>
    <div class="row mt-3 justify-content-center">
        <?php foreach ($libros as $libro) {
        ?>
            <div class="col-3 mb-3 ms-2 me-2">
                <div class="card">
                    <div class="card-body ps-0 pt-0 pe-0">
                        <img class="card-img-top img" src="<?= $libro['lib_imagen'] ?>" alt="Card image cap">
                    </div>
                    <div class="card-footer">
                        <h5 class="card-title text-truncate"><?= $libro['lib_titulo'] ?></h5>
                        <hr>
                        <div class="row">
                            <div class="col-7 text-start">
                                <label>Categoría:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['lib_categoria'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-7 text-start">
                                <label>Sub Categoría:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['lib_sub_categoria'] ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-4 text-start">
                                <label>Autor/es:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['lib_autores'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4 text-start">
                                <label>Idioma:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['lib_idioma'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-auto text-start">
                                <a class='' id="favorito_<?= $libro['id'] ?>" onclick='quitarFavorito(this.id)'><i id="estrella_<?= $libro['id'] ?>" class="fa-solid fa-star"></i></a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <?php if ($libro['lib_vigente'] == 'Si') { ?>
                                <div class="col">
                                    <button onclick="reservarLibro(<?= $libro['id'] ?>)" class="btn btn-primary">Reservar</button>
                                </div>
                            <?php } ?>
                        </div>
                        <?= Html::beginForm(['libro/view']) ?>
                        <input type="hidden" name="id" value="<?= $libro['id'] ?>"></input>
                        <input type="hidden" name="vuelta" value="site/index"></input>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Ver más</button>
                            </div>
                        </div>
                        <?= Html::endForm() ?>
                        <?= Html::beginForm(['comentario/index']) ?>
                        <input type="hidden" name="idLibro" value="<?= $libro['id'] ?>"></input>
                        <input type="hidden" name="tituloLibro" value="<?= $libro['lib_titulo'] ?>"></input>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Comentarios</button>
                            </div>
                        </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    function quitarFavorito(id) {
        id = id.split("_")[1];

        $.ajax({
            method: "POST",
            url: "<?= Url::toRoute(['favoritos/update']); ?>",
            data: {
                _csrf: "<?= Yii::$app->request->csrfToken; ?>",
                //idUsuario: idUsuario
                idLibro: id,
                fav: 'N'
            },
            success: function(result) {
                location.reload();
            }
        });
    }

    function reservarLibro(id = null) {
        if (id != null) {
            $("#libroId").val(id);
            $("#modalReserva").modal("show");
        } else {
            hoy = Date.now();

            if ((Date.parse($("#desde").val()) < Date.parse($("#hasta").val())) && (Date.parse($("#desde").val()) >= hoy)) {
                $("#fecha_desde").val($("#desde").val());
                $("#fecha_hasta").val($("#hasta").val());
                $("#formReserva").submit();
            } else {
                $("#modalReserva").modal("hide");
                $("#modalAdvertencia").modal("show");
            }
        }
    }
</script>