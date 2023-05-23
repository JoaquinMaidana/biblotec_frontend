<!DOCTYPE html>
<html lang="es-UY">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de libro favorito</title>
    <?php $libro = (object)$libro; //var_dump($libro);exit; ?>
    <style>
        label {
            width: 100%;
        }
    </style>
</head>
<body>
    <form>
        <label for="id"><strong>id:</strong> <?= $libro->id ?></label>
        <label for="isbn"><strong>ISBN:</strong> <?= $libro->lib_isbn ?></label>
        <label for="titulo"><strong>Titulo:</strong> <?= $libro->lib_titulo ?></label>
        <p for="descripcion"><strong>Descripcion:</strong> <?= $libro->lib_descripcion ?></p>
        <label for="imagen"><strong>Portada:</strong>
            <img object-fit src="<?=$libro->lib_imagen ?>" alt="No imagen">
        </label>
        <label for="categoria"><strong>Categoria:</strong> <?= $libro->lib_categoria ?></label>
        <label for="subcategoria"><strong>Subcategoria:</strong> <?= $libro->lib_sub_categoria ?></label>
        <label> <strong>URL compra:</strong> <a target="_blank" href="<?= $libro->lib_url ?>">URL compra</a></label>
        <label for="stock"><strong>Stock:</strong> <?= $libro->lib_stock ?></label>
        <label for="autores"><strong>Autores:</strong> <?= $libro->lib_autores ?></label>
        <label for="edicion"><strong>Edicion:</strong> <?= $libro->lib_edicion ?></label>
        <label for="fecha"><strong>Fecha de lanzamiento:</strong> <?= $libro->lib_fecha_lanzamiento ?></label>
        <label for="novedad">
        <strong>Es novedad:</strong> <?= $novedad = $libro->lib_novedades == 'S' ? 'Es novedad' : 'No es novedad'; ?>
        </label>
        <label for="idioma"><strong>Idioma</strong> : <?= $libro->lib_idioma ?></label>
        <label for="disponible"><strong>Disponible:</strong> <?= $disponibilidad = $libro->lib_disponible=='S' ? 'Disponible' : 'No disponible'; ?></label>
        <label for="vigente"><strong>Vigencia:</strong> <?= $vigencia = $libro->lib_vigente=='S' ? 'Vigente' : 'No vigente'; ?></label>
        <label for="puntuacion"><strong>Puntaje:</strong> <?= $libro->lib_puntuacion ?></label>
    </form>
    <input class="btn btn-primary" type="button" onclick="history.back()" value="Volver">
</body>
</html>
