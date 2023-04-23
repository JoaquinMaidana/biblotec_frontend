<?php 
    use yii\bootstrap5\Html;
    use yii\widgets\ActiveForm;


?>

<?php $form = ActiveForm::begin(['action' => ['libro/update', 'idlibros' => $libro['id']], 'options' => ['enctype' => 'multipart/form-data']]); ?>

<?= Html::label('ID', 'id') ?>
<?= Html::textInput('id', $libro['id'], ['class' => 'form-control']) ?>

<?= Html::label('ISBN', 'lib_isbn') ?>
<?= Html::textInput('lib_isbn', $libro['lib_isbn'], ['class' => 'form-control']) ?>

<?= Html::label('Título', 'lib_titulo') ?>
<?= Html::textInput('lib_titulo', $libro['lib_titulo'], ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Descripción', 'lib_descripcion') ?>
<?= Html::textarea('lib_descripcion', $libro['lib_descripcion'], ['rows' => 6, 'class' => 'form-control']) ?>

<?= Html::label('Imagen', 'lib_imagen') ?>
<?= Html::textInput('lib_imagen', $libro['lib_imagen'], ['class' => 'form-control']) ?>

<?= Html::label('Categoría', 'lib_categoria') ?>
<?= Html::textInput('lib_categoria', $libro['lib_categoria'], ['class' => 'form-control']) ?>

<?= Html::label('Subcategoría', 'lib_sub_categoria') ?>
<?= Html::textInput('lib_sub_categoria', $libro['lib_sub_categoria'], ['class' => 'form-control']) ?>

<?= Html::label('URL', 'lib_url') ?>
<?= Html::textInput('lib_url', $libro['lib_url'], ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Stock', 'lib_stock') ?>
<?= Html::textInput('lib_stock', $libro['lib_stock'], ['class' => 'form-control']) ?>

<?= Html::label('Autores', 'lib_autores') ?>
<?= Html::textInput('lib_autores', $libro['lib_autores'], ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Edición', 'lib_edicion') ?>
<?= Html::textInput('lib_edicion', $libro['lib_edicion'], ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Fecha de lanzamiento', 'lib_fecha_lanzamiento') ?>
<?= Html::textInput('lib_fecha_lanzamiento', $libro['lib_fecha_lanzamiento'], ['class' => 'form-control']) ?>

<?= Html::label('Novedades', 'lib_novedades') ?>
<?= Html::dropDownList('lib_novedades', $libro['lib_novedades'], [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>

<?= Html::label('Idioma', 'lib_idioma') ?>
<?= Html::textInput('lib_idioma', $libro['lib_idioma'], ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Disponible', 'lib_disponible') ?>
<?= Html::dropDownList('lib_disponible', $libro['lib_disponible'], [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>

<?= Html::label('Vigente', 'lib_vigente') ?>
<?= Html::dropDownList('lib_vigente', $libro['lib_vigente'], [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>

<?= Html::label('Puntuación', 'lib_puntuacion') ?>
<?= Html::textInput('lib_puntuacion', $libro['lib_puntuacion'], ['class' => 'form-control']) ?>

<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
