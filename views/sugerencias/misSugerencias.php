<!DOCTYPE html>
<html lang="es-UY">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis sugerencias</title>
    <?php 
        use yii\helpers\Html;
        use yii\helpers\Url;
        $sugerencias = json_decode($sugerencias); 
    ?>
</head>
<body>
    <h1>Mis sugerencias</h1>
    <button type="button" class="btn btn-dark"> <a class="nav-link" href="<?= Url::toRoute(['sugerencias/index']); ?>">Volver</a></button>
    <table id="activas" class="display compact">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Texto de sugerencia</th>
                    <th>Vigente</th>
                    <th>Usuario que realiza</th>
                    <th>Fecha realizacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($sugerencias != ""){
                
                    foreach($sugerencias as $sugerencia){
                        //var_dump(Yii::$app->user->identity->id, $sugerencia->sug_idusu);exit;
                         if($sugerencia->sug_idusu == Yii::$app->user->identity->id){
                ?>
                            <tr>
                                <td><?= $sugerencia->id; ?></td>
                                <td><?= $sugerencia->sug_sugerencia; ?></td>
                                <td><?= $sugerencia->sug_vigente; ?></td>
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
                                        </div>
                                    </div>
                                </div>
                            <?= Html::endForm() ?>
                <?php
                        }
                    }
                }
                ?>

            </tbody>
    </table>
    
</body>
</html>