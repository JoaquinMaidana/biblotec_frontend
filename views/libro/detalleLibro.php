<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

    $this->title = 'Libro: ' . $libro['lib_titulo'];
    if (Yii::$app->session->isActive) {      
        $documento = Yii::$app->session->get('usu_documento'); 
        $isAdmin = Yii::$app->session->get('usu_tipo_usuario');            
    }
 //   if(isset($comentarios) && !empty($comentarios) ){
 //       $idLibro = $comentarios[0]['comet_lib_id'];
 //   }
  $idLibro = $libro['lib_id'];
    
?>

<style>
    label,
    p {
        color: white;
    }

    blockquote p{
        color: black;
    }

    .highlight {
        background-color: red !important;
        ;
        color: white !important;

    }

     .labelReserva{
        color: black ;
    }
</style>

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-6">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <img src="<?= $libro['lib_imagen'] ?>"></img>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-3 text-end">
                        <label>Código:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_isbn'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Título:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_titulo'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Autor/es:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_autores'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Edición:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_edicion'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Fecha de lanzamiento:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_fecha_lanzamiento'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Idioma:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_idioma'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Descripción:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_descripcion'] ?></p>
                    </div>
                </div>



                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Puntuación:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_puntuacion'] ?></p>
                    </div>
                </div>



                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Disponible:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_disponible'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Novedad:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_novedades'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-center">
                    <div class="col-3 text-end">
                        <label>Stock:</label>
                    </div>
                    <div class="col">
                        <p><?= $libro['lib_stock'] ?></p>
                    </div>
                </div>

                <div class="row mt-3 justify-content-end">
                    <div class="col-auto">
                        <a href="<?= Url::toRoute([$vuelta]); ?>" class="btn btn-primary">Volver</a>
                    </div>
                    <div class="col-auto">
                    <button onclick="abrirReserva(<?= $libro['lib_id'] ?>)"  class="btn btn-primary">Reservar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="container-fluid">
    <div class="row mt-3 align-items-center">
        <div class="col text-truncate">
            <h2>Comentarios</h2>
        </div>
        <?php if (isset($isAdmin)) { ?> 
            <div class="col-auto d-flex justify-content-end">
                <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalNuevoComentario'>Nuevo comentario</button>
            </div>
        <?php } ?> 
    </div>

    <?php if (isset($comentarios) && !empty($comentarios)) { ?>
        <div class="row align-items-center">

            <?php foreach ($comentarios as $comentario) { ?>
                <div class="row mt-3">

                    <div class="col-12 mb-2 ">
                        <?= $this->render('_comentario', array('documento' => $comentario['usu_nombre'],'comentario' => $comentario['comet_comentario'], 'usuario' => $comentario['comet_usu'], 'fecha' => $comentario['comet_fecha_hora'], 'hijos' => $comentario['comentariosHijos'], 'id' => $comentario['comet_id'], 'referencia' => $comentario['comet_referencia_id'], 'padre' => $comentario['comet_padre_id'])); ?>
                    </div>

                    <hr>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="row mt-3 align-items-center">

            <h4>No hay comentarios</h4>


        </div>


    <?php } ?>
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
                            <label class="labelReserva">Desde:</label>
                        </div>
                        <div class="col">
                            <input  id="desde" placeholder="Ingrese la fecha de inicio" class="form-control"></input>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-3">
                            <label class="labelReserva">Hasta:</label>
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

<div id="modalEliminarComentario" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= Html::beginForm(['comentario/delete'], 'post') ?>
            <input type="hidden" name="id" id="idComentarioEliminar"></input>
            <input type="hidden" name="idLibro" value='<?= $idLibro ?>'></input>
            <input type="hidden" name="comentarioPadre" id="idComentarioPadre2"></input>
            <input type="hidden" name="comentario" value="" id="coment" >
            <input type="hidden" name="comentarioReferencia" id="idComentarioReferencia2"></input>
            <input type="hidden" name="token" value="" >
            
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <h5>¿Desea eliminar el comentario?</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalEliminarComentario').modal('hide');">Cancelar</button>
                <button type="submit" class="btn btn-primary">Eliminar</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<div id="modalNuevoComentario" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= Html::beginForm(['comentario/create'], 'post') ?>
            <input type="hidden" name="idLibro" value='<?= $idLibro ?>'></input>
            <input type="hidden" name="isbn" value='<?= $libro['lib_isbn'] ?>'></input>
            <input type="hidden" name="token" value="">

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <textarea class="form-control" name="comentario" id="comentarioNuevo"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalNuevoComentario').modal('hide');">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnComentar" disabled>Comentar</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<div id="modalResponderComentario" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Responder Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= Html::beginForm(['comentario/create'], 'post') ?>
            <input type="hidden" name="idLibro" value='<?= $idLibro ?>'></input>

            <input type="hidden" name="comentarioPadre" id="idComentarioPadre"></input>
            <input type="hidden" name="comentarioReferencia" id="idComentarioReferencia"></input>
            <input type="hidden" name="token" value="">
            <input type="hidden" name="isbn" value='<?= $libro['lib_isbn'] ?>'></input>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <textarea class="form-control" id="comentarioResponder" disabled></textarea>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3">
                        <div class="col">
                            <textarea class="form-control" name="comentario" id="comentarioRespuesta"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalResponderComentario').modal('hide');">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnRespuesa" disabled>Responder</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<div id="modalEditarComentario" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= Html::beginForm(['comentario/update'], 'post') ?>
            <input type="hidden" name="id" id="idComentario"></input>
            <input type="hidden" name="idLibro" value='<?= $idLibro ?>'></input>
            <input type="hidden" name="token" value="">
            <input type="hidden" name="isbn" value='<?= $libro['lib_isbn'] ?>'></input>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <textarea class="form-control" name="comentario" id="comentarioEditar"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="$('#modalEditarComentario').modal('hide');">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnEditar">Editar</button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comentarioRespuesta").on("input", function() {
            if ($("#comentarioRespuesta").val() != '') {
                $("#btnRespuesa").prop("disabled", false);
            } else {
                $("#btnRespuesa").prop("disabled", true);
            }
        });

        $("#comentarioNuevo").on("input", function() {
            if ($("#comentarioNuevo").val() != '') {
                $("#btnComentar").prop("disabled", false);
            } else {
                $("#btnComentar").prop("disabled", true);
            }
        });

        $("#comentarioEditar").on("input", function() {
            if ($("#comentarioEditar").val() != '') {
                $("#btnEditar").prop("disabled", false);
            } else {
                $("#btnEditar").prop("disabled", true);
            }
        });



    });
</script>

<script>
    function ocultarMostrarComentarios(padre) {
        if ($("#" + padre).is(":visible")) {
            $("#btn" + padre).removeClass("fa-arrow-up-long");
            $("#btn" + padre).addClass("fa-arrow-down-long");
            $("#" + padre).hide();
        } else {
            $("#btn" + padre).addClass("fa-arrow-up-long");
            $("#btn" + padre).removeClass("fa-arrow-down-long");
            $("#" + padre).show();
        }
    }
</script>

<script>
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

    let tokenElements = document.querySelectorAll('[name="token"]');

    if (tokenElements.length > 0) {
        let token = localStorage.getItem('TokenBibliotec_<?= $documento ?>');
        if (token) {
            tokenElements.forEach(function(element) {
                element.value = token;
            });
        } else {
            console.log('El token no está disponible.');
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

<script>
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

    function validarDiaSemana(input) {
        var dateValue = new Date(input.value);
        var dayOfWeek = dateValue.getDay();
        if (dayOfWeek === 6 || dayOfWeek === 5) {
            input.value = ''; // Limpiar el valor del campo
            $("#modalReserva").modal("hide");
            $("#advContenido").text("No se puede seleccionar los sabados y domingos")
            $("#modalAdvertencia").modal("show");
        }
    }

</script>

