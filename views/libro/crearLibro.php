<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */


$this->registerJsFile('@web/scanner/scanner.js');
$this->registerCssFile('@web/scanner/scanner.css');

if (isset($categorias)) {
  $categorias_string = json_encode($categorias);
}

?>
<style>
  .titulo {
    font-family: inherit;

  }

  label,
  p {
    color: white;
  }
</style>

<?php if (isset($libro) && !empty($libro) && $isGet === 'No') : ?>

  <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    <strong>Libro encontrado!</strong> Título: <?php echo $libro['lib_titulo']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <div class="d-flex justify-content-center">
    <img src="<?php echo  $libro['lib_imagen'] ?>" class="img-fluid shadow-lg border" alt="imagen del libro">
  </div>

<?php elseif (isset($libro) && count($libro) === 0 && $isGet === 'No') : ?>
  <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
    <strong>Libro no encontrado!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

<?php endif; ?>

<?php if (isset($mensaje) && !empty($mensaje)) : ?>
  <div class="alert alert-primary alert-dismissible fade show mb-3" role="alert">
    <strong>Mensaje</strong> Descripcion: <?php echo $mensaje; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col text-end">
      <button id="btn-scanner" class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseScanner" aria-expanded="false" aria-controls="collapseScanner">
        Mostrar Escaner
      </button>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-3 text-end">
      <label>Ingresar ISBN manualmente:</label>
    </div>
    <div class="col">
      <input id="txt-code" type="text" class="form-control">
    </div>
    <div class="col-auto">
      <button id="btn-code" class="btn btn-primary" onclick="completarCampos()">Completar campos</button>
    </div>
  </div>

  <div class="collapse" id="collapseScanner">
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

  <hr>

  <div class="row">
    <div class="col-12">
      <?php $form = ActiveForm::begin(['action' => ['libro/create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
      <div class="row justify-content-center">
        <div class="col-3 text-end">
          <label>ISBN:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textInput('lib_isbn', isset($libro) && !empty($libro) ? $libro['lib_isbn'] : null, ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Título:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textInput('lib_titulo', isset($libro) && !empty($libro) ? $libro['lib_titulo'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Autor/es:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textInput('lib_autores', isset($libro) && !empty($libro) ? $libro['lib_autores'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>

        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Edición:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textInput('lib_edicion', isset($libro) && !empty($libro) ? $libro['lib_edicion'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Fecha de lanzamiento:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textInput('lib_fecha_lanzamiento', isset($libro) && !empty($libro) ? $libro['lib_fecha_lanzamiento'] : null, ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Idioma:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textInput('lib_idioma', isset($libro) && !empty($libro) ? $libro['lib_idioma'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Descripción:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textarea('lib_descripcion', isset($libro) && !empty($libro) ? $libro['lib_descripcion'] : null, ['rows' => 6, 'class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Portada:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textInput('lib_imagen', isset($libro) && !empty($libro) ? $libro['lib_imagen'] : null, ['class' => 'form-control']) ?>
        </div>

      </div>



      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Categoría:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::dropDownList(
            'lib_categoria',
            isset($libro) && !empty($libro) ? $libro['lib_categoria'] : null,
            \yii\helpers\ArrayHelper::map($categorias, 'id', 'nombre'),
            ['id' => 'categoria-dropdown', 'prompt' => 'Seleccione una categoría', 'class' => 'form-control', 'required' => true]
          ) ?>

        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Sub Categoría:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::dropDownList('lib_sub_categoria', isset($libro) && !empty($libro) ? $libro['lib_sub_categoria'] : null, [], ['prompt' => 'Seleccione una subcategoría', 'class' => 'form-control', 'required' => true, 'id' => 'subcategoria']) ?>
        </div>
      </div>


      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Disponible:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::dropDownList('lib_disponible', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Novedad:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::dropDownList('lib_novedades', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Vigente:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::dropDownList('lib_vigente', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
        </div>
      </div>


      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Stock:<span class="text-danger">*<span></label>
        </div>
        <div class="col">
          <?= Html::textInput('lib_stock', null, ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-end">
        <div class="col-1">
          <a href="<?= Url::toRoute(['libro/index']); ?>" class="btn btn-outline-primary">Cancelar</a>
        </div>
        <div class="col-auto">
          <?= Html::submitButton('Crear', ['class' => 'btn btn-primary']) ?>
        </div>
      </div>

    </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>


<script>
  function completarCampos() {
    let isbn = $("#txt-code").val();
    let url = '<?= Yii::$app->urlManager->createUrl(['libro/completado', 'isbn' => '']) ?>' + encodeURIComponent(isbn);
    window.location.href = url;
  }

  const btnToggle = document.getElementById('btn-scanner');

  btnToggle.addEventListener('click', function() {
    const isExpanded = btnToggle.getAttribute('aria-expanded') === 'true';

    if (isExpanded) {
      btnToggle.innerHTML = 'Ocultar Escaner';
    } else {
      btnToggle.innerHTML = 'Mostrar Escaner';
    }
  });

  var categoriasSubcategorias = <?php echo $categorias_string ?>;

  var categoriaDropdown = document.getElementById("categoria-dropdown");
  var subcategoriaDropdown = document.getElementById("subcategoria");

  // Función para llenar el dropdown de subcategorías
  function llenarSubcategorias() {
    var categoriaId = parseInt(categoriaDropdown.value);

    // Limpiar el dropdown de subcategorías
    subcategoriaDropdown.innerHTML = "";

    // Buscar la categoría seleccionada en el arreglo
    var categoria = categoriasSubcategorias.find(function(c) {
      return c.id === categoriaId;
    });

    if (categoria) {
      // Rellenar el dropdown de subcategorías
      for (var i = 0; i < categoria.subCategorias.length; i++) {
        var subcategoria = categoria.subCategorias[i];
        var option = document.createElement("option");
        option.value = subcategoria.id;
        option.text = subcategoria.nombre;
        subcategoriaDropdown.appendChild(option);
      }
    }
    var libroSubCategoria = <?= isset($libro) && !empty($libro) ? $libro['lib_sub_categoria'] : 'null' ?>;
    if (libroSubCategoria !== null) {
      subcategoriaDropdown.value = libroSubCategoria;
    }
  }

  // Evento de cambio de selección de categoría
  categoriaDropdown.addEventListener("change", llenarSubcategorias);

  // Llamar a la función para llenar el dropdown por primera vez
  llenarSubcategorias();
</script>

<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="Recursos/scanner.js"></script>