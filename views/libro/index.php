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
 
   
<div id="tableContainer" style="overflow-x: auto;">
    <table id="myTable" class="display compact">
            <thead>
                <tr>
                    <th >id</th>
                    <th >Isbn</th>
                    <th >Titulo</th>
                    <th class="w-100">Descripcion</th>
                    <th>Imagen</th>
                    <th>Categoria</th>
                    <th>Sub Categoria</th>
                    <th >Url</th>
                    <th>Stock</th>
                    <th>Autores</th>
                    <th>Edicion</th>
                    <th>Fecha de lanzamiento</th>
                    <th>Novedades</th>
                    <th>Idioma</th>
                    <th>Disponible</th>
                    <th>Vigente</th>
                    <th>Puntuacion</th>
                
                </tr>
            </thead>
        </table>
</div>


</div>

<script>
    $(document).ready(function() {

        var libros = <?= $librosJson ?>;
        console.log(libros);
        //convertimos el json string a un objeto json
        //const librosArray = JSON.parse(JSON.stringify(libros));
       
        
        console.log("este es el libro" + libros);

        $('#myTable').DataTable({
            data: libros,
            columns: [
                    { data: 'id' },
                    { data: 'lib_isbn' },
                    { data: 'lib_titulo' },
                    { data: 'lib_descripcion' },
                    { data: 'lib_imagen' },
                    { data: 'lib_categoria' },
                    { data: 'lib_sub_categoria' },
                    { data: 'lib_url' },
                    { data: 'lib_stock' },
                    { data: 'lib_autores' },
                    { data: 'lib_edicion' },
                    { data: 'lib_fecha_lanzamiento' },
                    { data: 'lib_novedades' },
                    { data: 'lib_idioma' },
                    { data: 'lib_disponible' },
                    { data: 'lib_vigente' },
                    { data: 'lib_puntuacion' },
                ]
                ,
                autoWidth: false,
                deferRender: true,
                
        });
    });
</script>


