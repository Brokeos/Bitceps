<?php
use App\Templater;

Templater::render("header.html.php", $parameters);
?>
<section class="content">
    <div class="content-wrap pt-0">
        <div class="section m-0 login" style="background: #fff; margin-top: 150px !important;">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-8 col-md-8 offset-md-2">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4 class="mb-3">Se connecter</h4>
                                <div class="form-widget">
                                    <?php if (isset($error) && $error): ?>
                                    <div class="center">
                                        <div class="badge badge-pill badge-danger">Les informations de connexion sont incorrectes !</div>
                                    </div>
                                    <?php endif; ?>
                                    <form class="nobottommargin" action="<?= Templater::url('security.login.post') ?>" method="post">
                                        <div class="col_full mb-3">
                                            <label for="login_username">Adresse Email</label>
                                            <input type="text" id="login_username" name="email" class="form-control input-sm required" required>
                                        </div>
                                        <div class="col_full mb-3">
                                            <label for="login_password">Mot de passe</label>
                                            <input type="password" id="login_password" name="password" class="form-control input-sm required" required>
                                        </div>
                                        <div class="center">
                                            <div class="badge badge-pill badge-default"> <a href="/register">Pas encore inscrit ? Je m'inscris !</a></div>
                                        </div>
                                        <div class="col_full nobottommargin">
                                            <button class="button button-rounded btn-block nott ls0 m-0" type="submit" value="submit">Connexion</button>
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

