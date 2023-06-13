<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */


$this->title = 'My Yii Application';
if (isset($libros_Array)) {

    $novedadesArray = array_filter($libros_Array, function ($item) {
        return $item['lib_novedades'] === 'S';
    });
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
    <div class="row mt-3">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
            </div>
        </div>
    </div>
    <hr>
    <div class="row mt-3 justify-content-center">
        <?php foreach ($libros_Array as $libro) { ?>
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
                            <div class="col-4 text-start">
                                <label>Disponible:</label>
                            </div>
                            <div class="col text-end text-truncate">
                                <p class="card-text"><?= $libro['lib_disponible'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-auto text-start">
                                <a class='' id="favorito_<?= $libro['id'] ?>" onclick='agregarFavorito(this.id)'><i id="estrella_<?= $libro['id'] ?>" class="fa-regular fa-star"></i></a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <?php if ($libro['lib_disponible'] == 'S') { ?>
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

<div id="modalReserva" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservar libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= Html::beginForm(['reserva/create'], 'post', ['id' => 'formReserva']) ?>
            <input type="hidden" id="libroId" name="libro_id"></input>
            <input type="hidden" id="fecha_desde" name="fecha_desde"></input>
            <input type="hidden" id="fecha_hasta" name="fecha_hasta"></input>
            <div class="modal-body">
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
            <?= Html::endForm() ?>
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
                            <p>Rango de fechas invalido
                            <p>
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

<script>
    // Pasar el array novedadesArray de PHP a JavaScript
    var novedadesArray = <?php echo json_encode($novedadesArray); ?>;
    var novedadesArrayValues = Object.values(novedadesArray);
    // Utilizar el array en tu código JavaScript
    const swiperWrapper = document.querySelector('.swiper-wrapper');

    novedadesArrayValues.forEach(item => {
        const anchor = document.createElement('a');
        anchor.classList.add('swiper-slide');
        anchor.href = '<?= Yii::$app->urlManager->createUrl(["libro/view", "vuelta" => "site/index", "id2" => ""]) ?>' + item.id;

        const containerImg = document.createElement('div');
        containerImg.classList.add('conteiner-img');

        const image = document.createElement('img');
        image.src = item.lib_imagen;
        image.alt = '';

        containerImg.appendChild(image);
        anchor.appendChild(containerImg);
        swiperWrapper.appendChild(anchor);
    });

    novedadesArrayValues.forEach(item => {
        const anchor = document.createElement('a');
        anchor.classList.add('swiper-slide');
        anchor.href = '<?= Yii::$app->urlManager->createUrl(["libro/view", "id2" => ""]) ?>' + item.id;

        const containerImg = document.createElement('div');
        containerImg.classList.add('conteiner-img');

        const image = document.createElement('img');
        image.src = item.lib_imagen;
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
        } else {
            $("#estrella_" + id).removeClass("fa-solid fa-star");
            $("#estrella_" + id).addClass("fa-regular fa-star");
            fav = 'N';
        }

        $.ajax({
            method: "POST",
            url: "<?= Url::toRoute(['favoritos/update']); ?>",
            data: {
                _csrf: "<?= Yii::$app->request->csrfToken; ?>",
                //idUsuario: idUsuario
                idLibro: id,
                fav: fav
            },
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