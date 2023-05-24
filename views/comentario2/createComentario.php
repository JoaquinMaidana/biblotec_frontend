<?php 
    use yii\bootstrap5\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    /** @var yii\web\View $this */

     if (Yii::$app->session->isActive) {      
            $documento = Yii::$app->session->get('usu_documento');             
       }
   
?>

<div> hola </div>

<?php $form = ActiveForm::begin(['action' => ['comentario2/update'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
<label for="id">id</label>
<input type="text" name="id">
<input type="hidden" name="token" value="" id="token-field">
<label for="comet_fecha_hora">Comet Fecha y Hora:</label>
<input type="date" name="comet_fecha_hora" id="comet_fecha_hora" value="">

<label for="comet_usu_id">Comet Usuario ID:</label>
<input type="text" name="comet_usu_id" id="comet_usu_id" value="">

<label for="comet_lib_id">Comet Libro ID:</label>
<input type="text" name="comet_lib_id" id="comet_lib_id" value="">

<label for="comet_comentario">Comet Comentario:</label>
<input type="text" name="comet_comentario" id="comet_comentario" value="">

<label for="comet_referencia_id">Comet Referencia ID:</label>
<input type="text" name="comet_referencia_id" id="comet_referencia_id" value="">

<label for="comet_padre_id">Comet Padre ID:</label>
<input type="text" name="comet_padre_id" id="comet_padre_id" value="">


<input type="submit" value="Enviar">
<?php ActiveForm::end(); ?>


<script> 
    let token = localStorage.getItem('TokenBibliotec_<?=$documento ?>');
    if (token) {
    document.getElementById('token-field').value = token;
  } else {
    // El contenido de token es nulo o no existe
    // Puedes manejar esta situación según tus necesidades
    console.log('El token no está disponible.');
  }

</script>