<?php
use App\Templater;

Templater::render("header.html.php", $parameters);
?>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix" style="max-width: 1500px;">
                <div class="row">
                    <?php
                    Templater::render('admin/navbar.html.php');
                    ?>
                    <div class="nobottommargin clearfix col-md-9">
                        <h4>Participations</h4>
                        <div class="tabs tabs-bb mb-0 clearfix">
                            <ul class="tab-nav d-flex clearfix">
                                <?php foreach($days as $day): ?>
                                    <li class="flex-fill"><a href="#tabs-<?= $day ?>"><span class="d-none d-md-inline-block"></span><?= ucfirst($day) ?></a></li>
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
                                                            <div class="schedule-desc"><a href="<?= Templater::url('admin.planning' , ['id' => $lesson->getTrainer()->getId()]) ?>"><span class="badge badge-trainer float-right" style="background-color: <?= $lesson->getTrainer()->getColor() ?>"><?= $lesson->getTrainer()->getName() ?></span></a></div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <?php if (sizeof($lesson->getParticipations()) > 0): ?>
                                                                <a href="<?= Templater::url('admin.participations.lesson', ['id' => $lesson->getId()]) ?>" class="btn btn-primary btn-sm"><?= sizeof($lesson->getParticipations()) ?> Participant<?= sizeof($lesson->getParticipations()) > 1 ? 's' : '' ?></a>
                                                            <?php else: ?>
                                                                <div class="badge badge-pill badge-danger">Pas de participants</div>
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