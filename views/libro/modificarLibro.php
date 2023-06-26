<?php 
    use yii\bootstrap5\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    /** @var yii\web\View $this */

?>
<style>
  .titulo {
    font-family: inherit;
  }
</style>

<?php $form = ActiveForm::begin(['action' => ['libro/update'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row justify-content-center">
          <div class="col-3 text-end">
            <label>ISBN:<span class="text-danger">*<span></label>
          </
          <div class="col">
            <?= Html::textInput('lib_isbn', isset($libro) && !empty($libro) ? $libro['lib_isbn'] : null, ['class' => 'form-control']) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Título:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?= Html::textInput('titulo', isset($libro) && !empty($libro) ? $libro['lib_titulo'] : null, ['class' => 'form-control', 'maxlength' => true])?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Autor/es:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?=Html::textInput('autores', isset($libro) && !empty($libro) ? $libro['lib_autores'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>

          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Edición:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
         <?= Html::textInput('edicion', isset($libro) && !empty($libro) ? $libro['lib_edicion'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Fecha de lanzamiento:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?=Html::textInput('fecha_lanzamiento', isset($libro) && !empty($libro) ? $libro['lib_fecha_lanzamiento'] : null, ['class' => 'form-control']) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Idioma:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?=Html::textInput('idioma', isset($libro) && !empty($libro) ? $libro['lib_idioma'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Descripción:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?= Html::textarea('descripcion', isset($libro) && !empty($libro) ? $libro['lib_descripcion'] : null, ['rows' => 6, 'class' => 'form-control']) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Portada:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?=Html::textInput('imagen', isset($libro) && !empty($libro) ? $libro['lib_imagen'] : null, ['class' => 'form-control']) ?>
          </div>
          
        </div>

        

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Categoría:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?= Html::dropDownList('categoria',  null, 
            \yii\helpers\ArrayHelper::map($categorias, 'id', 'nombre'), 
            ['id' => 'categoria-dropdown', 'prompt' => 'Seleccione una categoría', 'class' => 'form-control', 'required' => true]) ?>

          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Sub Categoría:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
                <?= Html::dropDownList('sub_categoria',  null, [], ['prompt' => 'Seleccione una subcategoría', 'class' => 'form-control', 'required' => true, 'id' => 'subcategoria']) ?>   
          </div>
        </div>


        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Disponible:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?= Html::dropDownList('disponible', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Novedad:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?= Html::dropDownList('novedades', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Vigente:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
           <?= Html::dropDownList('vigente', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
          </div>
        </div>
       

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Stock:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?=Html::textInput('stock', null, ['class' => 'form-control']) ?>
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
</div>





<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<script src="Recursos/scanner.js"></script>
<?php
$this->registerJsFile('@web/scanner/scanner.js');




if(isset($categorias)){
  $categorias_string = json_encode($categorias);

}

?>

<script>
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
  var libroSubCategoria = <?=  'null' ?>;
    if (libroSubCategoria !== null) {
      subcategoriaDropdown.value = libroSubCategoria;
    }
}

// Evento de cambio de selección de categoría
categoriaDropdown.addEventListener("change", llenarSubcategorias);

// Llamar a la función para llenar el dropdown por primera vez
llenarSubcategorias();
</script>