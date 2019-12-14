<?php

use App\Helper;
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
                        <h4>Liste des participants au cours <?= $lesson->getName() ?> de <?= $lesson->getTrainer()->getName() ?> les <?= ucfirst($lesson->getDay()) ?>s de <?= $lesson->getHourStart() ?> à <?= $lesson->getHourEnd() ?></h4>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Age</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($lesson->getParticipations() as $participation): ?>
                                <tr>
                                    <td><?= $participation->getUser()->getLastname(); ?></td>
                                    <td><?= $participation->getUser()->getFirstname(); ?></td>
                                    <td><?= Helper::getUserAge($participation->getUser()) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
Templater::render("footer.html.php", $parameters);
?>