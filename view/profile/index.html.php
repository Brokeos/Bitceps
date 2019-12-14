<?php

use App\Kernel;
use App\Templater;

Templater::render("header.html.php", $parameters);
?>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix" style="max-width: 1500px;">
                <div class="row">
                    <div class="nobottommargin clearfix col-md-10 offset-1">
                        <h4>Mon profil</h4>
                        <form method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="lastname">Nom</label>
                                    <input type="text" class="form-control" id="lastname" value="<?= Kernel::getUser()->getLastname() ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="firstname">Prénom</label>
                                    <input type="text" class="form-control" id="firstname" value="<?= Kernel::getUser()->getFirstname() ?>" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Mail</label>
                                    <input type="text" class="form-control" id="email" value="<?= Kernel::getUser()->getEmail() ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="gender">Genre</label>
                                    <input type="text" class="form-control" id="gender" value="<?= Kernel::getUser()->getGender() == 'male' ? 'Homme' : 'Femme' ?>" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="birthdate">Date de naissance</label>
                                    <input type="date" class="form-control" id="birthdate" value="<?= Kernel::getUser()->getBirthdate()->format("Y-m-d") ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="subscription">Abonnement</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="subscription" value="<?= Kernel::getUser()->getSubscription() == null ? 'Aucun' : Kernel::getUser()->getSubscription()->getName() ?>" readonly>
                                        <?php if (Kernel::getUser()->getSubscription() != null): ?>
                                            <div class="input-group-append">
                                                <a href="<?= Templater::url('user.cancelsub') ?>" class="btn btn-danger">Annuler</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <h4>Modifier le mot de passe</h4>
                        <?php if (isset($errors) && count($errors) > 0): ?>
                            <div class="center">
                                <?php foreach($errors as $error): ?>
                                    <div class="badge badge-pill badge-danger"><?= $error ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($success) && $success): ?>
                            <div class="center">
                                <div class="badge badge-pill badge-success">Mot de passe modifié avec succès !</div>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Mot de passe actuel</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="newpassword">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="newpassword" name="newpassword">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirmnewpassword">Confirmation du nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="confirmnewpassword" name="confirmnewpassword">
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Modifier">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
Templater::render("footer.html.php", $parameters);
?>