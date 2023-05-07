<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->registerCssFile('@web/scanner/scanner.css');
$this->registerJsFile('@web/scanner/scanner.js');

if ($actualizar == 'N') {
  $this->title = 'Crear libro';
} else {
  $this->title = 'Actualizar libro';
}
?>

<style>
  .titulo {
    font-family: inherit;
  }
</style>

<div class="container-fluid">
  <div class="row mt-3 align-items-center">
    <div class="col-4">
      <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <?= Html::beginForm([$action], 'post', ['enctype' => 'multipart/form-data']) ?>
      <input name="id" type="text" class="form-control" hidden></input>
      <div class="container-fluid">

        <div class="row justify-content-center">
          <div class="col-3 text-end">
            <label>Código:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="isbn" type="text" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Título:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="titulo" type="text" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Autor/es:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="autor" type="text" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Edición:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="edicion" type="text" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Fecha de lanzamiento:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="fecha" type="date" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Idioma:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="idioma" type="text" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Descripción:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <textarea name="descripcion" class="form-control" required></textarea>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Portada:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="portada" type="file" class="form-control" accept=".jpg, .jpeg, .png"></input>
          </div>
          <?php if ($actualizar == 'S') { ?>
            <div class="col-auto">
              <button class="btn btn-primary" onclick="event.preventDefault();$('#modalPortada').modal('show')">Ver portada actual</button>
            </div>
          <?php } ?>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>URL:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="url" type="text" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Puntuación:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="puntuacion" type="text" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Subcategoría:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <select name="subcategoria" class="form-control" required>
              <?php foreach ($sub_categorias as $sub_categoria) { ?>
                <option value="<?= $sub_categoria->subcat_id ?>"><?= $sub_categoria->subcat_nombre ?></option>
              <?php  } ?>
            </select>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Disponible:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <select name="disponible" class="form-control" required>
              <option value="S" selected>Si</option>
              <option value="N">No</option>
            </select>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Novedad:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <select name="novedad" class="form-control" required>
              <option value="S" selected>Si</option>
              <option value="N">No</option>
            </select>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Stock:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <input name="stock" type="number" class="form-control" required></input>
          </div>
        </div>

        <div class="row mt-3 justify-content-end">
          <div class="col-1">
            <a href="<?= Url::toRoute(['libro/index']); ?>" class="btn btn-outline-primary">Cancelar</a>
          </div>
          <div class="col-auto">
            <button type="submit" id="botonSubmit" class="btn btn-primary">Crear</button>
          </div>
        </div>

      </div>
      <?= Html::endForm() ?>
    </div>
  </div>
</div>

<div id="modalScanner" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Código ISBN</h5>
        <button class="btn btn-primary" onclick="mostrarEscaner(this)">Mostrar escaner</button>
      </div>

      <?= Html::beginForm([''], '', ['onsubmit' => 'event.preventDefault();cargarDatos()']) //Este form esta para que funcione la validacion del campo si esta vacio o no
      ?>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-3 text-end">
              <label>Código:<span class="text-danger">*<span></label>
            </div>
            <div class="col">
              <input id="codigo" type="text" class="form-control" required></input>
            </div>
          </div>

          <div class="row mt-3 justify-content-center" id="collapseScanner">
            <div class="controls">
              <fieldset class="input-group">
                <button class="stop">Stop</button>
              </fieldset>
              <fieldset class="reader-config-group">
                <label>
                  <span>Barcode-Type</span>
                  <select name="decoder_readers">
                    <option value="code_128">Code 128</option>
                    <option value="code_39">Code 39</option>
                    <option value="code_39_vin">Code 39 VIN</option>
                    <option value="ean" selected="selected">EAN</option>
                    <option value="ean_extended">EAN-extended</option>
                    <option value="ean_8">EAN-8</option>
                    <option value="upc">UPC</option>
                    <option value="upc_e">UPC-E</option>
                    <option value="codabar">Codabar</option>
                    <option value="i2of5">Interleaved 2 of 5</option>
                    <option value="2of5">Standard 2 of 5</option>
                    <option value="code_93">Code 93</option>
                  </select>
                </label>
                <label>
                  <span>Resolution (width)</span>
                  <select name="input-stream_constraints">
                    <option value="320x240">320px</option>
                    <option value="640x480">640px</option>
                    <option value="800x600">800px</option>
                    <option selected="selected" value="1280x720">1280px</option>
                    <option value="1600x960">1600px</option>
                    <option value="1920x1080">1920px</option>
                  </select>
                </label>
                <label>
                  <span>Patch-Size</span>
                  <select name="locator_patch-size">
                    <option value="x-small">x-small</option>
                    <option value="small">small</option>
                    <option selected="selected" value="medium">medium</option>
                    <option value="large">large</option>
                    <option value="x-large">x-large</option>
                  </select>
                </label>
                <label>
                  <span>Half-Sample</span>
                  <input type="checkbox" checked="checked" name="locator_half-sample" />
                </label>
                <label>
                  <span>Workers</span>
                  <select name="numOfWorkers">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option selected="selected" value="4">4</option>
                    <option value="8">8</option>
                  </select>
                </label>
                <label>
                  <span>Camera</span>
                  <select name="input-stream_constraints" id="deviceSelection">
                  </select>
                </label>
                <label style="display: none">
                  <span>Zoom</span>
                  <select name="settings_zoom"></select>
                </label>
                <label style="display: none">
                  <span>Torch</span>
                  <input type="checkbox" name="settings_torch" />
                </label>
              </fieldset>
            </div>
            <div id="result_strip">
              <ul class="thumbnails"></ul>
              <ul class="collector"></ul>
            </div>
            <div id="interactive" class="viewport"></div>
            </section>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <a href="<?= Url::toRoute(['libro/index']); ?>" class="btn btn-outline-primary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Cargar datos</button>
      </div>
    </div>
  </div>
</div>

<div id="modalPortada" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Portada actual</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-auto">
              <input type="image" id="imagenPortada"></input>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="$('#modalPortada').modal('hide');">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {

    <?php if ($actualizar == 'N') { ?> //Si es crear libro
      $('#modalScanner').modal({
        backdrop: 'static',
        keyboard: false
      });

      $("[name='portada']").prop('required', true);
      $("#collapseScanner").hide();
      $("[class='stop']").hide();
      $("#modalScanner").modal("show");

    <?php } else { ?> //Si es actualizar libro
      $("[name='isbn']").val("<?= $libro['lib_isbn'] ?>");
      $("[name='id']").val("<?= $libro['id'] ?>");
      $("[name='titulo']").val("<?= $libro['lib_titulo'] ?>");
      $("[name='autor']").val("<?= $libro['lib_autores'] ?>");
      $("[name='edicion']").val("<?= $libro['lib_edicion'] ?>");
      $("[name='fecha']").val("<?= $libro['lib_fecha_lanzamiento'] ?>");
      $("[name='idioma']").val("<?= $libro['lib_idioma'] ?>");
      $("[name='descripcion']").val("<?= $libro['lib_descripcion'] ?>");
      $("#imagenPortada").attr("src", "<?= $libro['lib_imagen'] ?>");
      $("[name='url']").val("<?= $libro['lib_url'] ?>");
      $("[name='puntuacion']").val("<?= $libro['lib_puntuacion'] ?>");
      $("[name='subcategoria']").val("<?= $libro['lib_sub_categoria'] ?>");
      $("[name='disponible']").val("<?= $libro['lib_disponible'] ?>");
      $("[name='novedad']").val("<?= $libro['lib_novedades'] ?>");
      $("[name='stock']").val("<?= $libro['lib_stock'] ?>");
      $("#botonSubmit").text("Actualizar");
    <?php } ?>
  });

  function cargarDatos() {
    codigo = $("#codigo").val();

    $.ajax({
      method: "POST",
      url: "<?= Url::toRoute(['libro/completado']); ?>",
      data: {
        _csrf: "<?= Yii::$app->request->csrfToken; ?>",
        isbn: codigo,
      },
      success: function(result) {
        $("[name='isbn']").val(codigo);
        console.log(result); //Rellenar los campos 
        $("#modalScanner").modal("hide");
      },
    });
  }

  function mostrarEscaner(boton) {
    $('#collapseScanner').toggle();

    if ($(boton).text() == "Mostrar escaner") {
      $(boton).text("Ocultar escaner");
    } else {
      $(boton).text("Mostrar escaner");
    }
  }
</script>