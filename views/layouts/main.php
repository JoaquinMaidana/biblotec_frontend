<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

if (Yii::$app->session->getCount() == 1) {
    Yii::$app->session->close();
}

if (Yii::$app->session->isActive) {
    $isAdmin = Yii::$app->session->get('usu_tipo_usuario');
}
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="https://kit.fontawesome.com/663d89665d.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<link href="https://code.jquery.com/ui/1.13.2/themes/dark-hive/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

<style>
    body {
        background-color: #cbd0d5;
    }

    .marco {
        margin: 1%;
        background-color: #343a40;
        border-radius: 10px;
        padding: 10px;
    }

    .marcoNovedades {
        margin: 1%;
        background-color: #cbd0d5;
        border-radius: 10px;
        padding: 10px;
    }

    .navbar-expand-lg,
    .dropdown-menu {
        background-color: #343a40 !important;
    }

    .navbar-nav li a {
        color: #00c7ff;
    }

    .dropdown-item.disabled {
        color: white !important;
    }

    .btn-primary {
        background-color: #00c7ff;
        color: #343a40;
        border: 0px;
    }

    .btn-primary:hover,
    .btn-primary:active {
        background-color: #009dc9 !important;
        color: #343a40 !important;
    }

    .btn-outline-primary {
        color: white;
        border-color: #00c7ff;
    }

    .btn-outline-primary:hover {
        background-color: #00c7ff;
        border-color: #00c7ff;
        color: #343a40;
    }

    i,
    hr,
    h5,
    h1 {
        color: #00c7ff;
    }

    td,
    th,
    .dataTables_info {
        color: white !important;
    }

    .modal-header,
    .modal-footer {
        background-color: #343a40;
    }


    .modal-body {
        background-color: #cbd0d5;
    }

    .form-control,
    .form-control:focus {
        background-color: #cbd0d5;
        border-color: #343a40;
    }

    .card {
        background-color: #cbd0d5;
    }

    .tituloNovedades {
        color: #343a40;
    }

    .info:hover {
        cursor: pointer;
        color: #dfaa09 !important;
    }
</style>

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
            <a class="navbar-brand ms-4" href="<?= Url::toRoute(['site/index']); ?>"><img src="data:image/png;base64,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" width="40" height="40" alt="logo de UTEC"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent #navEnd" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                   
                   
                    
                    <?php if (isset($isAdmin)&& $isAdmin ==='Administrador') { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['libro/index']); ?>">Libros</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['favoritos/index']); ?>">Mis Favoritos</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['sugerencias/index']); ?>">Sugerencias</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['sugerencias/view']); ?>">Mis Sugerencias</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['usuario/index']); ?>">Usuarios</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['reserva/index']); ?>">Mis Reservas</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['reserva/index-admin']); ?>">Reservas</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['categoria/index']); ?>">Categorias</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['subcategoria/index']); ?>">Sub categorias</a>
                    </li>
                    <?php } else if(isset($isAdmin)&& $isAdmin ==='Estudiante'){?>
                        <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['reserva/index']); ?>">Mis Reservas</a>
                        </li>

                        <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['sugerencias/view']); ?>">Mis Sugerencias</a>
                        </li>

                        <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['favoritos/index']); ?>">Libros Favoritos</a>
                    </li>


                    <?php } ?>
                </ul>
                <ul class="navbar-nav mr-auto">

                    <?php if (Yii::$app->session->isActive) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= Yii::$app->session->get('usu_nombre') . " " . Yii::$app->session->get('usu_apellido') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item disabled" href="#"><?= Yii::$app->session['usu_tipo_usuario'] ?></a></li>
                                <form id="formCerrarSesion" action="<?= Url::toRoute(['site/logout']); ?>" method="post">
                                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                    <li><a class="dropdown-item" href="#" onclick="$('#formCerrarSesion').submit()">Cerrar sesión</a></li>
                                </form>
                            </ul>
                        </li>

                    <?php } else { ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= Url::toRoute(['site/login']); ?>">Iniciar sesión</a>
                        </li>
                    <?php } ?>

                </ul>
            </div>

        </nav>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container-fluid">
            <div class="marco">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </main>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>