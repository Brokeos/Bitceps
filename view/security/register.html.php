<?php
use App\Templater;

Templater::render("header.html.php", $parameters);
?>
<section class="content">
    <div class="content-wrap pt-0">
        <div class="section m-0 login" style="background: #fff; margin-top: 20px !important;">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-8 col-md-8 offset-md-2">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4 class="mb-3">S'inscrire</h4>
                                <div class="form-widget">
                                    <?php if (isset($errors) && count($errors) > 0): ?>
                                        <div class="center">
                                            <?php foreach($errors as $error): ?>
                                                <div class="badge badge-pill badge-danger"><?= $error ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($success) && $success): ?>
                                        <div class="center">
                                            <div class="badge badge-pill badge-success">Inscription réussie ! Vous pouvez désormais vous <a href="<?= Templater::url('security.login') ?>" style="color: white; text-decoration: underline !important;">connecter</a></div>
                                        </div>
                                    <?php endif; ?>
                                    <form class="nobottommargin" action="<?= Templater::url('security.register.post') ?>" method="post">
                                        <div class="col_full mb-3">
                                            <label for="register_email">Adresse email</label>
                                            <input type="text" id="register_email" name="email" class="form-control" required>
                                        </div>
                                        <div class="col_full mb-3">
                                            <label for="register_password">Mot de passe</label>
                                            <input type="password" id="register_password" name="password" class="form-control" required>
                                        </div>
                                        <div class="col_full mb-3">
                                            <label for="register_confirmpassword">Confirmation du mot de passe</label>
                                            <input type="password" id="register_confirmpassword" name="confirmpassword" class="form-control" required>
                                        </div>
                                        <div class="col_full mb-3">
                                            <label for="register_firstname">Prénom</label>
                                            <input type="text" id="register_firstname" name="firstname" class="form-control" required>
                                        </div>
                                        <div class="col_full mb-3">
                                            <label for="register_lastname">Nom</label>
                                            <input type="text" id="register_lastname" name="lastname" class="form-control" required>
                                        </div>
                                        <div class="col_full mb-3">
                                            <label for="register_gender">Sexe</label>
                                            <select name="gender" id="register_gender" class="form-control">
                                                <option value="male">Homme</option>
                                                <option value="female">Femme</option>
                                            </select>
                                        </div>
                                        <div class="col_full mb-3">
                                            <label for="register_birthdate">Date de naissance</label>
                                            <input type="date" id="register_birthdate" name="birthdate" class="form-control" required>
                                        </div>
                                        <div class="center">
                                            <div class="badge badge-pill badge-default"> <a href="<?= Templater::url('security.login') ?>">Déjà inscrit ?Je me connecte !</a></div>
                                        </div>
                                        <div class="col_full nobottommargin">
                                            <button class="button button-rounded btn-block nott ls0 m-0" type="submit" value="submit">Inscription</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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

