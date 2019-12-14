<?php

use App\Config;
use App\Kernel;
use App\Templater;

?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="rgautr01" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/bootstrap.css') ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/style.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/dark.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/swiper.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/font-icons.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/animate.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/magnific-popup.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/fonts.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/components/bs-switches.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/responsive.css'); ?>" type="text/css" />
    <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
    <link rel="stylesheet" href="<?= Templater::asset('css/custom.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?= Templater::asset('css/colors.php?color=3b7fed'); ?>" type="text/css" />
    <link rel="canonical" href="<?= Templater::url('home') ?>">

    <title><?= Config::$site['name'] ?> | <?= $title ?? '' ?></title>
</head>
<body class="stretched">
    <div id="wrapper" class="clearfix">
        <header id="header" class="full-header transparent-header <?= $active == 'home' ? 'dark' : 'sticky-header' ?>" data-sticky-class="not-dark">
            <div id="header-wrap">
                <div class="container clearfix">
                    <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
                    <div class="d-md-block d-lg-flex justify-content-between">
                        <div id="logo" class="m-0" style="width: 156px;">
                            <a href="<?= Templater::url('home') ?>" class="standard-logo" data-dark-logo="<?= Templater::asset('img/logod.png') ?>"><img src="<?= Templater::asset('img/logo.png') ?>"></a>
                            <a href="<?= Templater::url('home') ?>" class="retina-logo" data-dark-logo="<?= Templater::asset('img/logod.png') ?>"><img src="<?= Templater::asset('img/logo.png') ?>"></a>
                        </div>
                        <nav id="primary-menu" class="fnone not-dark">
                            <ul class="norightborder m-0 p-0">
                                <?= Templater::buildPrimaryNavbar($active) ?>
                                <?= Templater::buildConnectNavbar($active) ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>