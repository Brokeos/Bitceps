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
                        <h4>Liste des utilisateurs</h4>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Mail</th>
                                <th>Genre</th>
                                <th>Age</th>
                                <th>Abonnement</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($users as $user): ?>
                                <tr>
                                    <td><?= $user->getLastname(); ?></td>
                                    <td><?= $user->getFirstname(); ?></td>
                                    <td><?= $user->getEmail(); ?></td>
                                    <td><?= $user->getGender() == 'male' ? 'Homme' : 'Femme' ?></td>
                                    <td><?= Helper::getUserAge($user) ?></td>
                                    <td><?= $user->getSubscription() == null ? 'Aucun' : $user->getSubscription()->getName() ?></td>
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