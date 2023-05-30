<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Libro: ' . $libro['lib_titulo'];

?>

<div class="container-fluid">
    <div class="row mt-3 align-items-center">
        <div class="col">
            <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-4">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <input type="image" id="imagenPortada" src="<?= $libro['lib_imagen'] ?>"></input>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-3 text-end">
                        <label>Código:</label>
                    </div>
                    <div class="col">
                        <input disabled name="isbn" type="text" class="form-control" value="<?= $libro['lib_isbn'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Título:</label>
                    </div>
                    <div class="col">
                        <input disabled name="titulo" type="text" class="form-control" value="<?= $libro['lib_titulo'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Autor/es:</label>
                    </div>
                    <div class="col">
                        <input disabled name="autor" type="text" class="form-control" value="<?= $libro['lib_autores'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Edición:</label>
                    </div>
                    <div class="col">
                        <input disabled name="edicion" type="text" class="form-control" value="<?= $libro['lib_edicion'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Fecha de lanzamiento:</label>
                    </div>
                    <div class="col">
                        <input disabled name="fecha" type="date" class="form-control" value="<?= $libro['lib_fecha_lanzamiento'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Idioma:</label>
                    </div>
                    <div class="col">
                        <input disabled name="idioma" type="text" class="form-control" value="<?= $libro['lib_idioma'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Descripción:</label>
                    </div>
                    <div class="col">
                        <textarea disabled name="descripcion" class="form-control"><?= $libro['lib_descripcion'] ?></textarea>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>URL:</label>
                    </div>
                    <div class="col">
                        <input disabled name="url" type="text" class="form-control" value="<?= $libro['lib_url'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Puntuación:</label>
                    </div>
                    <div class="col">
                        <input disabled name="puntuacion" type="text" class="form-control" value="<?= $libro['lib_puntuacion'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Subcategoría:</label>
                    </div>
                    <div class="col">
                        <input disabled name="subcategoria" type="text" class="form-control" value="<?= $libro['lib_sub_categoria'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Disponible:</label>
                    </div>
                    <div class="col">
                        <input disabled name="disponible" class="form-control" value="<?= $libro['lib_disponible'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Novedad:</label>
                    </div>
                    <div class="col">
                        <input disabled name="novedad" class="form-control" value="<?= $libro['lib_novedades'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Stock:</label>
                    </div>
                    <div class="col">
                        <input disabled name="stock" type="number" class="form-control" value="<?= $libro['lib_stock'] ?>"></input>
                    </div>
                </div>

                <div class="row mt-3 justify-content-end">
                    <div class="col-auto">
                        <a href="<?= Url::toRoute([$vuelta]); ?>" class="btn btn-primary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>