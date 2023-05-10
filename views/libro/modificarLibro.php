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

<?php $form = ActiveForm::begin(['action' => ['libro/update', 'idlibros' => $libro['id']], 'options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="container-fluid">
  <div class="row mt-3 align-items-center">
    <div class="col-4">
      <h1 class="titulo"><?= Html::encode($this->title) ?></h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      
      
    <?php $form = ActiveForm::begin(['action' => ['libro/create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row justify-content-center">
          <div class="col-3 text-end">
            <label>ISBN:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?= Html::textInput('lib_isbn', isset($libro) ? $libro['lib_isbn'] : null, ['class' => 'form-control']) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Título:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?= Html::textInput('lib_titulo', isset($libro) ? $libro['lib_titulo'] : null, ['class' => 'form-control', 'maxlength' => true])?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Autor/es:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?=Html::textInput('lib_autores', isset($libro) ? $libro['lib_autores'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>

          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Edición:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
         <?= Html::textInput('lib_edicion', isset($libro) ? $libro['lib_edicion'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Fecha de lanzamiento:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?=Html::textInput('lib_fecha_lanzamiento', isset($libro) ? $libro['lib_fecha_lanzamiento'] : null, ['class' => 'form-control']) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Idioma:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?=Html::textInput('lib_idioma', isset($libro) ? $libro['lib_idioma'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Descripción:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?= Html::textarea('lib_descripcion', isset($libro) ? $libro['lib_descripcion'] : null, ['rows' => 6, 'class' => 'form-control']) ?>
          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Portada:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
            <?=Html::textInput('lib_imagen', isset($libro) ? $libro['lib_imagen'] : null, ['id' => 'portada','class' => 'form-control']) ?>
          </div>
          <div class="col-auto">
              <button id="mostrar-portada" class="btn btn-primary"  onclick="event.preventDefault();$('#modalPortada').modal('show')">Ver portada actual</button>
         </div>
          
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>URL:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?=Html::textInput('lib_url', isset($libro) ? $libro['lib_url'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
          </div>
        </div>


        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Categoría:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
          <?= Html::dropDownList('lib_categoria', null, 
            \yii\helpers\ArrayHelper::map($categorias, 'id', 'cat_nombre'), 
            ['id' => 'categoria-dropdown',
             'prompt' => 'Seleccione una categoría',
              'class' => 'form-control', 
              'required' => true]) ?>

          </div>
        </div>

        <div class="row mt-3 justify-content-center">
          <div class="col-3 text-end">
            <label>Sub Categoría:<span class="text-danger">*<span></label>
          </div>
          <div class="col">
                <?= Html::dropDownList('lib_sub_categoria', null, [], ['prompt' => 'Seleccione una subcategoría', 'class' => 'form-control', 'required' => true, 'id' => 'subcategoria']) ?>   
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
            <?=Html::textInput('lib_stock', isset($libro) ? $libro['lib_stock'] : null, ['class' => 'form-control']) ?>
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
              <input type="image" id="imagenPortada" src=""></input>
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
    $('#categoria-dropdown').change(function() {
        var categoriaId = $(this).val();
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["subcategoria/get-subcategoriasporid", "id_categoria" => ""]) ?>'+categoriaId,
            data: {id_categoria: categoriaId},
            success: function(response) {
                var subcategorias = JSON.parse(response);
                console.log(subcategorias);
                var options = '';
                for (var i = 0; i < subcategorias.length; i++) {
                    options += '<option value="' + subcategorias[i].id + '">' + subcategorias[i].subcat_nombre + '</option>';
                }
                $('#subcategoria').html(options);
              
            },
            error: function() {
                alert('Error al cargar subcategorías.');
            }
        });
    });

    $('#mostrar-portada').on('click', function() {
      let imagen = $('#portada').val(); // Obtenemos el valor del input
      $('#imagenPortada').attr('src', imagen); // Asignamos el valor al atributo src de la imagen del modal
      //$('#modalPortada').modal('show'); // Mostramos el modal
    });

    

    $("[name='portada']").prop('required', true);

});

</script>