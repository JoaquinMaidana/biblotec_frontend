<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

//var_dump($libros_Array);exit;
$this->title = 'Inicio';
   if(isset($libros_Array)){
      
      $novedadesArray = array_filter($libros_Array, function($item) {
         return $item['novedades'] === 'S';
     });
    
   }


if (isset($favoritos) && !empty($favoritos)) {
    $ids = array_column($favoritos, 'id');
}


?>
<style>
    .card {
        height: 100% !important;
    }

    .card button {
        width: 100%;
    }

    .search-txt i {
        font-size: 40px;
        color: #f8010a
    }

    .search-txt h2 {
        color: #111111;
        font-size: 30px;
        margin-left: 10px;
    }

    .movies {
        padding: 50px 0 150px 0;
    }

    .movies h2 {
        font-size: 25px;
        font-weight: 400;
        margin-bottom: 20px;
    }

    .swiper {
        width: 100%;
    }

    .swiper-slide {
        background-position: center;
        background-size: cover;
        width: 250px;
        height: auto;
    }



    .swiper-slide img {
        display: block;
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .conteiner-img {
        height: 100%;
    }

    @media(max-width:991px) {
        body {
            min-height: 0vh;
        }

        .search {
            padding: 30px 30px 0 30px
        }

        .movies {
            padding: 30px;
        }
    }
</style>
<div class="container-fluid">
    <div class="marcoNovedades">
        <div class="row mt-3 justify-content-center">
            <div class="col-auto">
                <h1 class="tituloNovedades">Novedades</h1>
            </div>
        </div>

        <div class="row mt-3 ms-3 me-3 justify-content-center">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="row mt-3 justify-content-center">
        <div class="col-6 ps-0">
            <input id="filtroTitulo" type="text" class="form-control" placeholder="Buscar libro" oninput="filtrarLibros()"></input>
        </div>
        <div class="col-3 pe-0 ps-4 ms-2">
            <select id="filtroCategoria" class="form-control" onchange="filtrarLibros()">
                <option value="">Filtrar por categoría</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?= $categoria['nombre'] ?>"><?= $categoria['nombre'] ?></option>
                <?php  } ?>
            </select>
        </div>
    </div>

    <div class="row mt-3 justify-content-center">
        <?php foreach ($libros_Array as $libro) {
        ?>
            <div class="col-3 mb-3 ms-2 me-2">
                <div class="card">
                    <div class="card-body ps-0 pt-0 pe-0">
                        <img class="card-img-top img" src="<?= $libro['imagen'] ?>" alt="Card image cap">
                    </div>
                    <div class="card-footer">
                        <h5 id="<?= $libro['id'] ?>" class="card-title text-truncate"><?= $libro['titulo'] ?></h5>
                        <hr>
                        <div class="row">
                            <div class="col-7 text-start">
                                <label>Categoría:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p id="categoria_<?= $libro['id'] ?>" class="card-text"><?= $libro['categorias'][0]['categoria'] ?></p>
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
                                <a class='' id="favorito_<?= $libro['id'] ?>" onclick='agregarFavorito(this.id)'><i id="estrella_<?= $libro['id'] ?>" class="<?= (isset($favoritos) && !empty($favoritos) && in_array($libro['id'], $ids)) ? 'fa-solid fa-star' : 'fa-regular fa-star' ?>"></i></a>
                            </div>


                        </div>
                        <div class="row mt-2">
                            <?php if ($libro['vigencia'] == 'Si') { ?>
                                <div class="col">
                                    <button onclick="$('#modalReserva').modal('show');$('#libroId').val(<?= $libro['id'] ?>)" class="btn btn-primary">Reservar</button>
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
<p id="response"> </p>
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
                            <input type="date" id="desde" class="form-control"></input>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-3">
                            <label>Hasta:</label>
                        </div>
                        <div class="col">
                            <input type="date" id="hasta" class="form-control"></input>
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
    // Pasar el array novedadesArray de PHP a JavaScript
    var novedadesArray = <?php echo json_encode($novedadesArray); ?>;
    var novedadesArrayValues = Object.values(novedadesArray);
    // Utilizar el array en tu código JavaScript
    const swiperWrapper = document.querySelector('.swiper-wrapper');

    novedadesArrayValues.forEach(item => {
        const anchor = document.createElement('a');
        anchor.classList.add('swiper-slide');
        anchor.href = '<?= Yii::$app->urlManager->createUrl(["libro/view", "vuelta" => "site/index", "id2" => ""]) ?>' + item.isbn;

        const containerImg = document.createElement('div');
        containerImg.classList.add('conteiner-img');

        const image = document.createElement('img');
        image.src = item.imagen;
        image.alt = '';

        containerImg.appendChild(image);
        anchor.appendChild(containerImg);
        swiperWrapper.appendChild(anchor);
    });

    novedadesArrayValues.forEach(item => {
        const anchor = document.createElement('a');
        anchor.classList.add('swiper-slide');
        anchor.href = '<?= Yii::$app->urlManager->createUrl(["libro/view", "id2" => ""]) ?>' + item.isbn;

        const containerImg = document.createElement('div');
        containerImg.classList.add('conteiner-img');

        const image = document.createElement('img');
        image.src = item.imagen;
        image.alt = '';

        containerImg.appendChild(image);
        anchor.appendChild(containerImg);
        swiperWrapper.appendChild(anchor);
    });

    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverFlowEffect: {
            rotate: 15,
            strech: 0,
            depth: 300,
            modifier: 1,
            slideShadows: true,
        },
        loop: true,
    });

    function agregarFavorito(id) {
        id = id.split("_")[1];

        if ($("#estrella_" + id).hasClass("fa-regular fa-star")) {
            $("#estrella_" + id).removeClass("fa-regular fa-star");
            $("#estrella_" + id).addClass("fa-solid fa-star");
            fav = 'S';

            $.ajax({
                method: "POST",
                url: "<?= Url::toRoute(['favoritos/update']); ?>",
                data: {
                    _csrf: "<?= Yii::$app->request->csrfToken; ?>",
                    idLibro: id,
                    fav: fav
                },
            });
        } else {
            $("#estrella_" + id).removeClass("fa-solid fa-star");
            $("#estrella_" + id).addClass("fa-regular fa-star");
            fav = 'N';
        }
    }

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
                        $("#resultado").text("Para reservar debe iniciar sesión o registrarse. ");
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

    function filtrarLibros() {

        titulo = $("#filtroTitulo").val();
        categoria = $("#filtroCategoria").val();

        $(".card-title").each(function() {

            idLibro = $(this).attr("id");

            categoriaLibro = $("#categoria_" + idLibro).text();

            tituloLibro = $(this).text().toLowerCase();
            tituloLibro = tituloLibro.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

            if ((tituloLibro.includes(titulo) || titulo == null) && (categoriaLibro == categoria || categoria == "")) {
                $(this).closest(".col-3").show();
            } else {
                $(this).closest(".col-3").hide();
            }
        });
    }
</script>