<?php


use yii\helpers\Html;
use yii\helpers\Url;


/** @var yii\web\View $this */

$this->title = 'Sugerencias';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php //var_dump($params);exit;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugerencias</title>
    <style> 
    table {
        border: 1px solid #000;
        width: 100%;
    }
    table  th, td {
     text-align: center;
     
     
     vertical-align: top;
     border: 1px solid #000;
     border-spacing: 0;
     padding: 0.2em;
     
    }

</style>
<script>
    $(document).ready(function () {
    $('#todas').DataTable();
    });
</script>
</head>
<body>
<div class="sugerencias-index">

<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?= Html::a('Crear Sugerencias', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Mis Sugerencias', ['view'], ['class' => 'btn btn-primary']) ?>
</p>


<!-- <p>
    ?php $url = Url::to(['sugerencias/update', 'idsugerencias'=>1 ]);
   // var_dump($url);exit; [Url::to(['sugerencias/modificar-sugerencia', 'idsugerencia'=>1 ])] ?>
    ?= Html::a('Editar Sugerencias',$url , ['class' => 'btn btn-success'])  ?>
</p> -->

<?php $sugerencias = json_decode($sugerenciasJson); ?>

<h2>Todas las sugerenciasss</h2>
<hr>
    <table id="todas" class="display compact">
        <thead>
            <tr>
                <th>id</th>
                <th>Texto de sugerencia</th>
                <th>Estado</th>
                <th>Usuario que realiza</th>
                <th>Fecha realizacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($sugerencias as $sugerencia){
                ?>
                <tr>
                    <td><?= $sugerencia->id; ?></td>
                    <td><?= $sugerencia->sug_sugerencia; ?></td>
                    <td><?= $estado = $sugerencia->sug_vigente=='S' ? 'Activa' : 'Revisada'; ?></td>
                    <td><?= $sugerencia->sug_idusu; ?></td>
                    <td><?= $sugerencia->sug_fecha; ?></td>
                    <td><a class='btn btn-warning' onclick="$('#modalCambiarEstado<?=$sugerencia->id ?>').modal('show');">Cambiar estado</a></td>
                    
                </tr>
                    <?= Html::beginForm(['sugerencias/update'], 'post') ?>
                                    
                    <div id="modalCambiarEstado<?= $sugerencia->id?>" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cambiar de estado</h5>
                            <label for="estact">
                                 Estado actual: <input type="text" name="estact" value="<?= $estado = $sugerencia->sug_vigente=='S' ? 'Activa' : 'Revisada'; ?>" disabled>
                            </label>
                            <label for="nuevoEstado">Pasar a estado: 
                                <select name="nuevoEstado">
                                    <?php if ($sugerencia->sug_vigente=='S'){
                                     echo '<option value="N">Revisada</option>'; 
                                    } else { 
                                     echo '<option value="S">Activa</option>';
                                    } ?>
                                </select>
                            </label>
                            <input type="hidden" name="id" value="<?= $sugerencia->id;?>"></input>
                            <input type="hidden" name="sug_sugerencia" value="<?= $sugerencia->sug_sugerencia;?>"></input>
                            <input type="hidden" name="sug_idusu" value="<?= $sugerencia->sug_idusu;?>"></input>
                            <input type="hidden" name="sug_fecha" value="<?= $sugerencia->sug_fecha;?>"></input>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col" id="textoModalDesactivar">
                                    <p>Confirmar cambio de estado</p>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary"  onclick="$('#modalCambiarEstado<?=$sugerencia->id ?>').modal('hide');">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                    <?= Html::endForm() ?>
            
               
            <?php }?>
        </tbody>
    </table>
</body>
</html>

