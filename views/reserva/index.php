<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Mis reservas';
?>

<style>
    img {
        height: 30rem;
    }

    .card h5,
    .card p {
        color: black;
    }

    .card {
        height: 100% !important;
    }

    .card button {
        width: 100%;
    }
</style>

<div class="container-fluid">
    <div class="row mt-3 align-items-center">
        <div class="col-3">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row mt-3">
        <?php foreach ($reservasLibros as $reservaLibro) { ?>
            <div class="col-4">
                <?php switch ($reservaLibro['reserva']->resv_estado) {
                    case "C": ?>
                        <div class="card bg-success">
                        <?php break;
                    case "X": ?>
                            <div class="card bg-danger">
                            <?php break;
                        case "P": ?>
                                <div class="card bg-warning">
                            <?php break;
                    } ?>
                            <img class="card-img-top" src="<?= $reservaLibro['libro']['lib_imagen'] ?>" alt="<?= $reservaLibro['libro']['lib_titulo'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $reservaLibro['libro']['lib_titulo'] ?></h5>
                                <p class="card-text">Reservado desde: <?= $reservaLibro['reserva']->resv_fecha_desde ?></p>
                                <p class="card-text">Reservado hasta: <?= $reservaLibro['reserva']->resv_fecha_hasta ?></p>
                                <p class="card-text">Estado: <?= $reservaLibro['reserva']->resv_estado ?></p>
                                <?php if ($reservaLibro['reserva']->resv_estado == "P") { ?>
                                    <button class="btn btn-primary" onclick="cancelarReserva('<?= $reservaLibro['libro']['lib_titulo'] ?>', '<?= $reservaLibro['reserva']->resv_id ?>')">Cancelar reserva</button>
                                <?php } ?>
                            </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
            </div>

            <div id="modalCancelarReserva" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cancelar reserva</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <?= Html::beginForm(['reserva/cancelar-reserva'], 'post') ?>
                        <input type="hidden" name="id" id="idReserva"></input>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col" id="textoModalCancelarReserva">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" onclick="$('#modalCancelarReserva').modal('hide');">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Cancelar reserva</button>
                        </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>

            <script>
                function cancelarReserva(tituloLibro, idReserva) {
                    $("#textoModalCancelarReserva").empty();
                    $("#textoModalCancelarReserva").append("¿Desea cancelar la reserva del libro " + tituloLibro + "?");
                    $("#modalCancelarReserva").modal("show");
                }
            </script>