<?php

use App\Kernel;
use App\Templater;

Templater::render("header.html.php", $parameters);
?>
<section id="slider" class="slider-element swiper_wrapper full-screen clearfix" data-loop="true">
    <div class="swiper-container swiper-parent">
        <div class="swiper-wrapper">
            <div class="swiper-slide dark" style="background-image: url('<?= Templater::asset('img/adult-1850925_1920.jpg') ?>'); background-size: cover;">
                <div class="container clearfix">
                    <div class="slider-caption slider-caption-center">
                        <h2>Progressez rapidement</h2>
                        <div class="d-md-flex divcenter d-none categories-lists mt-5" style="width: 60%;">
                            <div class="mr-auto">
                                <span class="list-group-item h6 t300 py-2 px-1 nobg border-0"><i class="icon-line-plus mr-2"></i>Wi-Fi Gratuit</span>
                                <span class="list-group-item h6 t300 py-2 px-1 nobg border-0"><i class="icon-line-plus mr-2"></i>Coach</span>
                            </div>
                            <div class="">
                                <span class="list-group-item h6 t300 py-2 px-1 nobg border-0"><i class="icon-line-plus mr-2"></i>30 Machines</span>
                                <span class="list-group-item h6 t300 py-2 px-1 nobg border-0"><i class="icon-line-plus mr-2"></i>Douches</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center divcenter categories-lists mt-4">
                            <div class="d-flex t600 ml-2 mb-0 p-2 h5 text-dark center justify-content-center align-items-center" style="background: url('<?= Templater::asset('img/brush.png'); ?>')no-repeat center center / cover; width: 180px; height: 50px"><span class="align-self-center"><?= $tarif->getPrice() ?>.00€/m</span></div>
                            <?php if (Kernel::isAuthed()): ?>
                                <a href="<?= Templater::url("tarifs") ?>" class="button button-rounded button-large nott ml-4 align-self-center">Nos Tarifs</a>
                            <?php else: ?>
                                <a href="<?= Templater::url("security.register") ?>" class="button button-rounded button-large nott ml-4 align-self-center">S'inscrire</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="content">
    <div class="content-wrap nopadding">
        <div class="section nomargin">
            <div class="container clearfix">
                <div class="divcenter center" style="max-width: 900px;">
                    <h2 style="font-size: 42px;" class="nobottommargin t700 ls1">Matériel</h2>
                    <span style="font-size: 16px;" class="t300 ls1 notopmargin">Matériel Premium en Libre Service</span>
                </div>
            </div>
        </div>
        <div class="masonry-thumbs grid-4" data-lightbox="gallery">
            <a href="<?= Templater::asset('img/cross-fit-1126999_1920.jpg') ?>" data-lightbox="gallery-item"><img class="image_fade" src="<?= Templater::asset('img/cross-fit-1126999_1920.jpg') ?>"><i class="icon-resize-full"></i></a>
            <a href="<?= Templater::asset('img/dumbbell-1966247_1920.jpg') ?>" data-lightbox="gallery-item"><img class="image_fade" src="<?= Templater::asset('img/dumbbell-1966247_1920.jpg') ?>"><i class="icon-resize-full"></i></a>
            <a href="<?= Templater::asset('img/dumbbell-1966702_1920.jpg') ?>" data-lightbox="gallery-item"><img class="image_fade" src="<?= Templater::asset('img/dumbbell-1966702_1920.jpg') ?>"><i class="icon-resize-full"></i></a>
            <a href="<?= Templater::asset('img/dumbbells-1634750_1920.jpg') ?>" data-lightbox="gallery-item"><img class="image_fade" src="<?= Templater::asset('img/dumbbells-1634750_1920.jpg') ?>"><i class="icon-resize-full"></i></a>
        </div>
        <div class="section nomargin">
            <div class="container clearfix">
                <div class="heading-block nobottomborder center nomargin">
                    <h2 style="font-size: 42px;" class="nobottommargin nott t700 ls1">Entraineurs Professionnels</h2>
                    <span style="font-size: 16px;" class="t300 ls1 notopmargin">Suivez les cours de nos entraineurs</span>
                </div>
            </div>
        </div>
        <div class="portfolio portfolio-3 portfolio-full grid-container portfolio-nomargin clearfix">
            <?php foreach ($trainers as $trainer): ?>
            <article class="portfolio-item pf-media pf-icons">
                <div class="portfolio-image">
                    <a href="<?= Templater::url('planning.trainer', ['id' => $trainer->getId()]) ?>">
                        <img src="<?= Templater::asset('img/trainers/' . $trainer->getPicture()) ?>">
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3 style="font-size: 32px;"><?= $trainer->getName() ?></h3>
                                <span><?= $trainer->getCategory() ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <div class="section nomargin" style="padding: 80px 0;">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="hidden-xs hidden-sm hidden-md topmargin-lg"></div>
                        <div class="emphasis-title bottommargin-sm">
                            <h2 style="font-size: 38px;" class="font-body t600">Suivi personnalisé</h2>
                        </div>
                        <p style="color: #777; margin-bottom: 25px;" class="lead">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce faucibus maximus odio, vitae hendrerit nisl rhoncus vitae. Maecenas et ex vitae tellus lobortis tincidunt in at elit.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div style="box-shadow: 0 1px 8px 0 rgba(0,0,0,0.3);">
                            <img src="<?= Templater::asset('img/sport-2260736_1920.jpg') ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
Templater::render("footer.html.php", $parameters);
?>
