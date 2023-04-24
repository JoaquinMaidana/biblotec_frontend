<?php


use yii\helpers\Html;


/** @var yii\web\View $this */

$this->title = 'Libros';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="libro-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Crear Libro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 
     <table id="myTable">
    <thead>
        <tr>
            <th>Libro id</th>
            <th>Libro isbn</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($libros_Array as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['lib_isbn'] ?></td>
                <td>
                        <?= Html::a('Detalle libro', ['view', 'idlibros' => $row['id']], ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Modificar libro', ['update', 'idlibros' => $row['id']], ['class' => 'btn btn-secondary']) ?>
                        <?= Html::a('Borrar libro', ['delete', 'idlibros' => $row['id']], ['class' => 'btn btn-danger']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>


    
</table>
    


</div>



