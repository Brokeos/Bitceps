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
                            <div class="container clearfix">
                                <div class="error404 center">404</div>
                                <div class="heading-block nobottomborder center nobottommargin">
                                    <h4>La page que vous avez demandée est introuvable !</h4>
                                    <span>Nous sommes désolés mais la page que vous avez demandée n’existe pas ou n’est plus disponible.<br>Veuillez utiliser les liens ci-dessus pour naviguer vers une autre page, ou revenez en arrière. </span>
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

