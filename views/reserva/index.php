<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Mis reservas';
$nombreEstado=null;
?>

<style>
    .card-img-top {
        height: 50rem;
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
    <div class="row align-items-center">
        <div class="col-3">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row mt-3">
        <?php foreach ($reservasLibros as $reservaLibro) {
            
            ?>
            <div class="col-4 mb-3">
                <?php switch ($reservaLibro['reserva']->resv_estado) {
                    case "C": 
                    $nombreEstado = 'Confirmada';
                    ?>
                        <div class="card bg-success">
                        <?php break;
                    case "L": 
                        $nombreEstado = 'Libro levantado';
                        ?>
                            <div class="card bg-success">
                            <?php break;
                    case "X":
                    $nombreEstado = 'Cancelada'; ?>
                        <div class="card   ">
                        <?php break;
                    case "P": 
                        $nombreEstado = 'Pendiente';?>
                            <div class="card bg-warning">
                        <?php break;
                    case "D": 
                        $nombreEstado = 'Completada';?>
                            <div class="card bg-success">
                        <?php break;
                    case "N": 
                        $nombreEstado = 'Libro no devuelto';?>
                            <div class="card bg-danger">
                        <?php break;
                    } ?>
                            <img class="card-img-top" src="<?= $reservaLibro['libro']['lib_imagen'] ?>" alt="<?= $reservaLibro['libro']['lib_titulo'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $reservaLibro['libro']['lib_titulo'] ?></h5>
                                <p class="card-text">Reservado desde: <?= $reservaLibro['reserva']->resv_fecha_desde ?></p>
                                <p class="card-text">Reservado hasta: <?= $reservaLibro['reserva']->resv_fecha_hasta ?></p>
                                <p class="card-text">Estado: <?= $nombreEstado ?></p>
                                <?php if ($reservaLibro['reserva']->resv_estado == "P") { ?>
                                    <button class="btn btn-primary" onclick="cancelarReserva('<?= $reservaLibro['libro']['lib_titulo'] ?>', '<?= $reservaLibro['reserva']->resv_id ?>')">Cancelar reserva</button>
                                
                                    <button class="btn btn-primary mt-2" onclick="levantarLibro('<?= $reservaLibro['libro']['lib_titulo'] ?>', '<?= $reservaLibro['reserva']->resv_id ?>')">Levantar Libro</button>
                                <?php } ?>
                                <?= Html::beginForm(['libro/view']) ?>
                                <input type="hidden" name="id" value="<?= $reservaLibro['libro']['lib_isbn'] ?>"></input>
                                <input type="hidden" name="vuelta" value="site/index"></input>
                                <div class="row mt-2">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Ver más</button>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>
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
                        <input type="hidden" name="id_reserva" id="idReserva"></input>
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

            <div id="modalLevantarLibro" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Levantar Libro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <?= Html::beginForm(['reserva/levantar-libro'], 'post') ?>
                        <input type="hidden" name="id_reserva" id="idReserva2"></input>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col" id="textoModalLevantarLibro">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" onclick="$('#modalLevantarLibro').modal('hide');">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Levantar Libro</button>
                        </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>


            <script>
                function cancelarReserva(tituloLibro, idReserva) {
                    $("#textoModalCancelarReserva").empty();
                    $("#textoModalCancelarReserva").append("¿Desea cancelar la reserva del libro " + tituloLibro + "?");
                    $('#idReserva').val(idReserva);
                   
                    $("#modalCancelarReserva").modal("show");
                }

                function levantarLibro(tituloLibro, idReserva) {
                    $("#textoModalLevantarLibro").empty();
                    $("#textoModalLevantarLibro").append("¿Desea levantar el libro  " + tituloLibro + "?");
                    $('#idReserva2').val(idReserva);
                   
                    $("#modalLevantarLibro").modal("show");
                }
            </script>