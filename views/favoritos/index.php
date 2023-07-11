<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Mis favoritos';
?>

<style>
    .card {
        height: 100% !important;
    }

    .card button {
        width: 100%;
    }

    .highlight {
        background-color: red !important;
        ;
        color: white !important;

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
                        <img class="card-img-top img" src="<?= $libro['imagen'] ?>" alt="Card image cap">
                    </div>
                    <div class="card-footer">
                        <h5 class="card-title text-truncate"><?= $libro['titulo'] ?></h5>
                        <hr>
                        <div class="row">
                            <div class="col-7 text-start">
                                <label>Categoría:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['categorias'][0]['categoria'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-7 text-start">
                                <label>Sub Categoría:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['categorias'][0]['subCategoria'] ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-4 text-start">
                                <label>Autor/es:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['autores'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4 text-start">
                                <label>Idioma:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['idioma'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-auto text-start">
                                <a class='' id="favorito_<?= $libro['id'] ?>" onclick='quitarFavorito(this.id)'><i id="estrella_<?= $libro['id'] ?>" class="fa-solid fa-star"></i></a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <?php if ($libro['vigencia'] == 'Si') { ?>
                                <div class="col">
                                <button onclick="abrirReserva(<?= $libro['id'] ?>)"  class="btn btn-primary">Reservar</button>
                                </div>
                            <?php } ?>
                        </div>
                        <?= Html::beginForm(['libro/view']) ?>
                        <input type="hidden" name="id" value="<?= $libro['isbn'] ?>"></input>
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

<div id="modalReserva" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservar libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="libroId"></input>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-3">
                            <label>Desde:</label>
                        </div>
                        <div class="col">
                            <input  id="desde" placeholder="Ingrese la fecha de inicio" class="form-control"></input>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-3">
                            <label>Hasta:</label>
                        </div>
                        <div class="col">
                            <input  id="hasta" placeholder="Ingrese la fecha de fin" class="form-control"></input>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalReserva').modal('hide');">Cancelar</button>
                <button onclick="reservarLibro()" class="btn btn-primary">Reservar</button>
            </div>

        </div>
    </div>
</div>


<div id="modalAdvertencia" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <p>Rango de fechas invalido</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="$('#modalAdvertencia').modal('hide');$('#modalReserva').modal('show');">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalResultado" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservar libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <p id="resultado"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="$('#modalResultado').modal('hide');">Aceptar</button>
            </div>
        </div>
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

    var blockedDates = ["2023-07-18","2023-07-19","2023-07-20","2023-07-12","2023-07-13","2023-07-14","2023-07-25","2023-07-26","2023-07-27","2023-07-28"];
    var highlightedDates = ["2023-07-18","2023-07-19","2023-07-20","2023-07-12","2023-07-13","2023-07-14","2023-07-25","2023-07-26","2023-07-27","2023-07-28"];
    $(function () {
        $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '< Ant',
        nextText: 'Sig >',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);

        

        $("#desde").datepicker({
            beforeShowDay: function (date) {
                var stringDate = $.datepicker.formatDate('yy-mm-dd', date);
                var day = date.getDay();
                var isWeekend = (day === 0 || day === 6);
                //var blockedDates = ['2023-07-10', '2023-07-11', '2023-07-12'];
               // var highlightedDates = ['2023-07-10', '2023-07-11', '2023-07-12'];

                var isBlocked = (blockedDates.indexOf(stringDate) !== -1);
                var isHighlighted = (highlightedDates.indexOf(stringDate) !== -1);

                return [
                    !isBlocked && !isWeekend, // Habilitar o deshabilitar el día
                    (isHighlighted ? 'highlight' : '') // Clase CSS para días resaltados
                ];
            },
            minDate: new Date()
            
            
        });

        $("#hasta").datepicker({
            beforeShowDay: function (date) {
                var stringDate = $.datepicker.formatDate('yy-mm-dd', date);
                var day = date.getDay();
                var isWeekend = (day === 0 || day === 6);
                //var blockedDates = ['2023-07-10', '2023-07-11', '2023-07-12'];
               // var highlightedDates = ['2023-07-10', '2023-07-11', '2023-07-12'];

                var isBlocked = (blockedDates.indexOf(stringDate) !== -1);
                var isHighlighted = (highlightedDates.indexOf(stringDate) !== -1);

                return [
                    !isBlocked && !isWeekend, // Habilitar o deshabilitar el día
                    (isHighlighted ? 'highlight' : '') // Clase CSS para días resaltados
                ];
            },
            minDate: new Date()
            
            
        });
    });

    function reservarLibro() {
        hoy = Date.now();

        if ((Date.parse($("#desde").val()) < Date.parse($("#hasta").val())) && (Date.parse($("#desde").val()) >= hoy)) {

            $.ajax({
                method: "POST",
                url: "<?= Url::toRoute(['reserva/create']); ?>",
                data: {
                    _csrf: "<?= Yii::$app->request->csrfToken; ?>",
                    libro_id: $("#libroId").val(),
                    fecha_desde: $("#desde").val(),
                    fecha_hasta: $("#hasta").val()
                },
                success: function(result) {
                    $("#modalReserva").modal("hide");
                    console.log(result);
                    if (result == 1 ) {
                        $("#resultado").text("Libro reservado con exito.");
                    }
                    else if (result ==2){
                        $("#resultado").text("Error en los datos enviados ");
                    }
                    else if (result ==3){
                        $("#resultado").text("No se ha adjuntado el token para poder resolver esta petición ");
                    }
                    else {
                        if(result){
                            let errors = JSON.parse(result);

                            // Generar el contenido HTML de los errores con saltos de línea
                            let html = errors.join("<br>");
                            $("#resultado").html(html);
                        }else{
                            $("#resultado").text("Hubo un error");
                        }
                       
                    } 
                    $("#modalResultado").modal("show");
                }
            });

        } else {
            $("#modalReserva").modal("hide");
            $("#modalAdvertencia").modal("show");
        }
    }

    function abrirReserva(id){
        $.ajax({
                method: "GET",
                url: "<?= Url::toRoute(['reserva/fechas-bloqueadas']); ?>",
                data: {
                    _csrf: "<?= Yii::$app->request->csrfToken; ?>",
                    id: id 
                },
                success: function (result) {
                    console.log(result)
                    let fechasBloqueadas = JSON.parse(result);

                     blockedDates = fechasBloqueadas;
                     highlightedDates = fechasBloqueadas;
                    
                     $('#libroId').val(id);
                    $('#modalReserva').modal('show');
                   
                }
            });
      

    }
</script>