<?php

use App\Kernel;
use App\Templater;

Templater::render("header.html.php", $parameters);
?>
<section class="content">
    <div class="content-wrap nopadding">
        <div class="section nomargin">
            <div class="container clearfix">
                <div class="divcenter center" style="max-width: 900px;">
                    <h2 style="font-size: 42px;" class="nobottommargin t700 ls1"><?= $title ?></h2>
                    <span style="font-size: 16px;" class="t300 ls1 notopmargin">Participez aux cours de la semaine</span>
                </div>
            </div>
        </div>
        <div id="section-schedule" class="section page-section nobg pt-0 topmargin-lg clearix">
            <div class="container clearfix">
                <div class="schedule-wrap divcenter rounded" style="max-width: 1000px;">
                    <div class="center">
                        <?php if (Kernel::isAuthed()): ?>
                            <?php if (Kernel::getUser()->getSubscription() != null): ?>
                                <div class="badge badge-pill badge-info">Une fois inscrit aux cours, vous serez automatiquent réinscrit à chaque nouvelle semaine.</div>
                            <?php else: ?>
                                <div class="badge badge-pill badge-danger">Vous devez d'abord vous abonner pour participer à des cours.</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="tabs tabs-bb mb-0 clearfix" id="tab-9">
                        <ul class="tab-nav d-flex clearfix">
                            <?php foreach($dates as $day => $date): ?>
                            <li class="flex-fill"><a href="#tabs-<?= $day ?>"><span class="d-none d-md-inline-block"></span><?= ucfirst($day) . ' ' . $date ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tab-container mt-3">
                            <?php foreach($groupedLessons as $day => $lessons): ?>
                            <div class="tab-content clearfix" id="tabs-<?= $day ?>">
                                <dl class="row mb-0">
                                    <?php foreach($lessons as $lesson):  ?>
                                    <dd class="col-sm-12">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-sm-2">
                                                <div class="schedule-time font-primary float-right"><strong><?= $lesson->getHourStart() ?> - <?= $lesson->getHourEnd() ?></strong></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="schedule-desc"><?= $lesson->getName() ?></div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="schedule-desc"><a href="<?= Templater::url('planning.trainer', ['id' => $lesson->getTrainer()->getId()]) ?>"><span class="badge badge-trainer float-right" style="background-color: <?= $lesson->getTrainer()->getColor() ?>"><?= $lesson->getTrainer()->getName() ?></span></a></div>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php if (Kernel::isAuthed()): ?>
                                                    <?php if (isset($participations) && in_array($lesson->getId(), $participations)): ?>
                                                        <a href="<?= Templater::url('user.participation.del', ['id' => $lesson->getId()]) ?>" class="button button-small button-black button-dark bg-dark mt-2 mt-sm-0 float-none float-sm-right">Annuler</a>
                                                    <?php else: ?>
                                                        <?php if (Kernel::getUser()->getSubscription() != null): ?>
                                                            <a href="<?= Templater::url('user.participation.add', ['id' => $lesson->getId()]) ?>" class="button button-small button-black button-dark bg-dark mt-2 mt-sm-0 float-none float-sm-right">Participer</a>
                                                        <?php else: ?>
                                                            <a href="<?= Templater::url('tarifs') ?>" class="button button-small button-black button-dark bg-dark mt-2 mt-sm-0 float-none float-sm-right">Nos tarifs</a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <a href="<?= Templater::url('security.login') ?>" class="button button-small button-black button-dark bg-dark mt-2 mt-sm-0 float-none float-sm-right">Connexion</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </dd>
                                    <?php endforeach; ?>
                                </dl>
                            </div>
                            <?php endforeach; ?>
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
