<?php

use App\Kernel;
use App\Templater;

Templater::render("header.html.php", $parameters);
?>
<section id="content">
    <div class="content-wrap nopadding">
        <div class="section nomargin nopadding" style="background: url('<?= Templater::asset('img/Working-Out-With-Chalk.jpg') ?>') center center no-repeat; background-size: cover;">
            <div class="section nomargin" style="background: rgba(0,0,0,0.3);">
                <div class="container clearfix">
                    <div class="heading-block dark nobottomborder nobottommargin center">
                        <h2 style="font-size: 40px;" class="nott t700 ls1">Nos Tarifs</h2>
                        <h6>Des justificatifs peuvent être demandés</h6>
                    </div>
                </div>
            </div>
            <div class="section nomargin nobg">
                <div class="container clearfix">
                    <div class="pricing row bottommargin-sm clearfix">
                        <?php foreach($tarifs as $tarif): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="pricing-box">
                                <div class="pricing-title">
                                    <h3><?= $tarif->getName() ?></h3>
                                </div>
                                <div class="pricing-price">
                                    <?= $tarif->getPrice() ?><span class="price-unit">€</span><span class="price-tenure">Mensuel</span>
                                </div>
                                <div class="pricing-features">
                                    <ul>
                                        <li>Accès à <strong>Tout le Matériel</strong></li>
                                        <li>Accès <strong>Casier</strong></li>
                                        <li>Accès <strong>Douche</strong></li>
                                        <li>Du <strong>Lundi</strong> au <strong>Samedi</strong></li>
                                        <li><strong>7H</strong> jusqu'à <strong>23H</strong></li>
                                    </ul>
                                </div>
                                <div class="pricing-action">
                                    <?php if (Kernel::isAuthed()): ?>
                                        <a href="<?= Templater::url("user.checkout", ['id' => $tarif->getId()]) ?>" class="button button-large button-dark button-rounded capitalize button-circle ls0">Choisir</a>
                                    <?php else: ?>
                                        <a href="<?= Templater::url("security.register") ?>" class="button button-large button-dark button-rounded capitalize button-circle ls0">S'inscrire</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
Templater::render("footer.html.php", $parameters);
?>

