<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm; 
/** @var yii\web\View $this */
  $this->title = 'Registro';
?>

<style>
  label {
    color: white;
  }
</style>

<div class="container-fluid col-7">

  <?php ActiveForm::begin(['action' => ['site/registro'], 'options' => ['enctype' => 'multipart/form-data']]); ?>

  <div class="row justify-content-center">

  <?php if (isset($mensaje) && !empty($mensaje)) : ?>
  <div class="alert alert-primary alert-dismissible fade show mb-3 co-3" role="info">
    <strong>Mensaje</strong> Descripcion: <?php echo $mensaje; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
    <div class="col-3 text-end">
      <label>Nombre:<span class="text-danger">*<span></label>
    </div>
    <div class="col">
      <?= Html::textInput('usu_nombre', null, ['class' => 'form-control']) ?>
    </div>
  </div>

  <div class="row mt-3 justify-content-center">
    <div class="col-3 text-end">
      <label>Apellido:<span class="text-danger">*<span></label>
    </div>
    <div class="col">
      <?= Html::textInput('usu_apellido',  null, ['class' => 'form-control', 'maxlength' => true]) ?>
    </div>
  </div>

  <div class="row mt-3 justify-content-center">
    <div class="col-3 text-end">
      <label>Documento:<span class="text-danger">*<span></label>
    </div>
    <div class="col">
      <?= Html::textInput('usu_documento',  null, ['class' => 'form-control', 'maxlength' => true]) ?>

    </div>
  </div>

  <div class="row mt-3 justify-content-center">
    <div class="col-3 text-end">
      <label>Email:<span class="text-danger">*<span></label>
    </div>
    <div class="col">
      <input type="email" name="usu_mail" class="form-control">
    </div>
  </div>

  <div class="row mt-3 justify-content-center">
    <div class="col-3 text-end">
      <label>Clave:<span class="text-danger">*<span></label>
    </div>
    <div class="col">
      <?= Html::passwordInput('usu_clave',  null, ['class' => 'form-control']) ?>
    </div>
  </div>

  <div class="row mt-3 justify-content-center">
    <div class="col-3 text-end">
      <label>Telefono:<span class="text-danger">*<span></label>
    </div>
    <div class="col">
      <input type="number" name="usu_telefono" class="form-control">
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

  <?php ActiveForm::end(); ?>
</div>