<?php 
    use yii\bootstrap5\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    /** @var yii\web\View $this */


?>


<div class="mt-5">
      <?php $form = ActiveForm::begin(['action' => ['site/login'], 
      'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Documento</label>
          <?= Html::textInput('documento', null, ['class' => 'form-control', 'maxlength' => true]) ?>
          
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Contraseña</label>
          <?= Html::passwordInput('contrasena', null, ['class' => 'form-control', 'maxlength' => true]) ?>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Registrarse', ['site/registro'], ['class' => 'btn btn-secondary ms-3']) ?>
        <?php ActiveForm::end(); ?> 

</div>
