<?php 
    use yii\bootstrap5\Html;
    use yii\widgets\ActiveForm;


?>

<?php $form = ActiveForm::begin(['action' => ['libro/create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>

<?= Html::label('ID', 'id') ?>
<?= Html::textInput('id', null, ['class' => 'form-control']) ?>

<?= Html::label('ISBN', 'lib_isbn') ?>
<?= Html::textInput('lib_isbn', null, ['class' => 'form-control']) ?>

<?= Html::label('Título', 'lib_titulo') ?>
<?= Html::textInput('lib_titulo', null, ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Descripción', 'lib_descripcion') ?>
<?= Html::textarea('lib_descripcion', null, ['rows' => 6, 'class' => 'form-control']) ?>

<?= Html::label('Imagen', 'lib_imagen') ?>
<?= Html::textInput('lib_imagen', null, ['class' => 'form-control']) ?>

<?= Html::label('Categoría', 'lib_categoria') ?>
<?= Html::textInput('lib_categoria', null, ['class' => 'form-control']) ?>

<?= Html::label('Subcategoría', 'lib_sub_categoria') ?>
<?= Html::textInput('lib_sub_categoria', null, ['class' => 'form-control']) ?>

<?= Html::label('URL', 'lib_url') ?>
<?= Html::textInput('lib_url', null, ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Stock', 'lib_stock') ?>
<?= Html::textInput('lib_stock', null, ['class' => 'form-control']) ?>

<?= Html::label('Autores', 'lib_autores') ?>
<?= Html::textInput('lib_autores', null, ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Edición', 'lib_edicion') ?>
<?= Html::textInput('lib_edicion', null, ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Fecha de lanzamiento', 'lib_fecha_lanzamiento') ?>
<?= Html::textInput('lib_fecha_lanzamiento', null, ['class' => 'form-control']) ?>

<?= Html::label('Novedades', 'lib_novedades') ?>
<?= Html::dropDownList('lib_novedades', null, [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>

<?= Html::label('Idioma', 'lib_idioma') ?>
<?= Html::textInput('lib_idioma', null, ['class' => 'form-control', 'maxlength' => true]) ?>

<?= Html::label('Disponible', 'lib_disponible') ?>
<?= Html::dropDownList('lib_disponible', null, [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>

<?= Html::label('Vigente', 'lib_vigente') ?>
<?= Html::dropDownList('lib_vigente', null, [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>

<?= Html::label('Puntuación', 'lib_puntuacion') ?>
<?= Html::textInput('lib_puntuacion', null, ['class' => 'form-control']) ?>

<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
