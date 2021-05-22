<?php

use App\Utils\Auth;
use App\Utils\Env;

/**
 * @var Auth $auth
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="msapplication-tap-highlight" content="no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="">

    <link rel="icon" href="<?= url('favicon-32x32.png') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= url('favicon-32x32.png') ?>" type="image/x-icon">

    <script src="<?= url('dist/app.js') ?>"></script>
    <title><?= $_ENV['APP_NAME'] ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid p-2">
        <a class="navbar-brand text-uppercase fw-bold" href="<?= url() ?>"><?= Env::get('APP_NAME') ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" tabindex="-1">Link</a>
                </li>
            </ul>
            <div>
                <?php if ($auth->check()): ?>
                    <a href="<?= url('logout') ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-sign-in"></i> Logout
                    </a>
                <?php else: ?>
                    <a href="<?= url('login') ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-sign-in-alt"></i> Login
                    </a>
                    <a href="<?= url('register') ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid p-3">
    <?= $this->section('contents') ?>
</div>

<?= $this->section('script') ?>

</body>
</html>