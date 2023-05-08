<?php 
    use yii\bootstrap5\Html;
    use yii\widgets\ActiveForm;

    /** @var yii\web\View $this */

   

    $this->registerCssFile('@web/scanner/scanner.css');

?>

<?php if (isset($libro) && !empty($libro)): ?>

  
  <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    <strong>Libro encontrado!</strong> Título: <?php echo $libro['lib_titulo']; ?> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <div class="d-flex justify-content-center">
      <img src="<?php echo  $libro['lib_imagen'] ?>" class="img-fluid shadow-lg border" alt="imagen del libro">
  </div>
  
<?php elseif (isset($libro) && empty($libro)): ?>
  <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
    <strong>Libro no encontrado!</strong> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  
<?php endif; 


?>


<h2 >Código seleccionado: <span id="code_selected"></span></h2>
<p>
 
  <button id="btn-scanner" class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseScanner" aria-expanded="false" aria-controls="collapseScanner">
    Mostrar Escaner
  </button>
</p>
<h3>Ingresar manualmente</h3>
<input id="txt-code" type="text" id="code_selected">
<button id="btn-code" class="btn btn-primary" type="button">Ingresar</button>
<br>
<div class="collapse" id="collapseScanner">
  <div class="controls">
      <fieldset class="input-group">
        <button class="stop">Stop</button>
      </fieldset>
      <fieldset class="reader-config-group">
        <label>
                      <span>Barcode-Type</span>
                      <select name="decoder_readers">
                          <option value="code_128" >Code 128</option>
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
                          <option  value="640x480">640px</option>
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
  


<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
  function completarCampos() {
    let isbn = document.getElementById("code_selected").innerText;
    let url = '<?=Yii::$app->urlManager->createUrl(['libro/completado', 'isbn' => ''])?>' + encodeURIComponent(isbn);
    window.location.href = url;
  }

  $(document).ready(function() {
    $("#btn-code").on("click", function() {
      let txtCodeVal = $("#txt-code").val();
      $("#code_selected").html(txtCodeVal);
    });
  });


  const btnToggle = document.getElementById('btn-scanner');
  
  btnToggle.addEventListener('click', function() {
    const isExpanded = btnToggle.getAttribute('aria-expanded') === 'true';
    
    if (isExpanded) {
      btnToggle.innerHTML = 'Ocultar Escaner';
    } else {
      btnToggle.innerHTML = 'Mostrar Escaner';
    }
  });
</script>

<?= Html::a('Completar campos', 'javascript:void(0);', ['class' => 'btn btn-success', 'onclick' => 'completarCampos();']) ?>

<?php $form = ActiveForm::begin(['action' => ['libro/create'], 'options' => ['enctype' => 'multipart/form-data']]); 


 echo Html::label('ISBN', 'lib_isbn');
 echo Html::textInput('lib_isbn', isset($libro) ? $libro['lib_isbn'] : null, ['class' => 'form-control']) ;

 echo Html::label('Título', 'lib_titulo') ;
 echo Html::textInput('lib_titulo', isset($libro) ? $libro['lib_titulo'] : null, ['class' => 'form-control', 'maxlength' => true]);

 echo Html::label('Descripción', 'lib_descripcion') ;
 echo Html::textarea('lib_descripcion', isset($libro) ? $libro['lib_descripcion'] : null, ['rows' => 6, 'class' => 'form-control']);

 echo Html::label('Imagen', 'lib_imagen');
 echo Html::textInput('lib_imagen', isset($libro) ? $libro['lib_imagen'] : null, ['class' => 'form-control']);

 echo Html::label('Categoría', 'lib_categoria');
 echo Html::textInput('lib_categoria', null, ['class' => 'form-control']);
 echo Html::label('Subcategoría', 'lib_sub_categoria') ;
 echo Html::textInput('lib_sub_categoria', null, ['class' => 'form-control']);

 echo Html::label('URL', 'lib_url') ;
 echo Html::textInput('lib_url', isset($libro) ? $libro['lib_url'] : null, ['class' => 'form-control', 'maxlength' => true]);

 echo Html::label('Stock', 'lib_stock');
 echo Html::textInput('lib_stock', null, ['class' => 'form-control']);

 echo Html::label('Autores', 'lib_autores') ;
 echo Html::textInput('lib_autores', isset($libro) ? $libro['lib_autores'] : null, ['class' => 'form-control', 'maxlength' => true]);

 echo Html::label('Edición', 'lib_edicion') ;
 echo Html::textInput('lib_edicion', isset($libro) ? $libro['lib_edicion'] : null, ['class' => 'form-control', 'maxlength' => true]);

 echo Html::label('Fecha de lanzamiento', 'lib_fecha_lanzamiento');
 echo Html::textInput('lib_fecha_lanzamiento', isset($libro) ? $libro['lib_fecha_lanzamiento'] : null, ['class' => 'form-control']);

 echo Html::label('Novedades', 'lib_novedades') ;
 echo Html::dropDownList('lib_novedades', null, [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']);

 echo Html::label('Idioma', 'lib_idioma') ;
 echo Html::textInput('lib_idioma', isset($libro) ? $libro['lib_idioma'] : null, ['class' => 'form-control', 'maxlength' => true]);

 echo Html::label('Disponible', 'lib_disponible');
 echo Html::dropDownList('lib_disponible', null, [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']);

 echo Html::label('Vigente', 'lib_vigente');
 echo Html::dropDownList('lib_vigente', null, [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']);

 ?>

<div class="form-group pt-3">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<script src="Recursos/scanner.js"></script>
<?php
$this->registerJsFile('@web/scanner/scanner.js');




?>