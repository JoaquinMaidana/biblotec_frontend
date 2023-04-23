<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Libros';
?>
<div class="libro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table id="myTable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Autor</th>
                <th>Cantidad de paginas</th>
                <th>Año de lanzamiento</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    $(document).ready(function() {

        var data = [
            [
                "El imperio final",
                "Brandon Sanderson",
                "541",
                "2006"
            ],
            [
                "Amanecer rojo",
                "Pierce Brown",
                "544",
                "2014"
            ]
        ]

        $('#myTable').DataTable({
            data: data,
        });
    });
</script>