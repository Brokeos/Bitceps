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
                                <h4 class="mb-3">Paiement</h4>
                                <?php if (isset($tarif)): ?>
                                    <p><strong>Abonnement choisi :</strong> <?= $tarif->getName() ?></p>
                                    <p><strong>Prix :</strong> <?= $tarif->getPrice() ?> €</p>
                                    <div class="align-right">
                                        <form class="nobottommargin" action="<?= Templater::url('user.checkout.post', ['id' => $tarif->getId()]) ?>" method="post">
                                            <button class="button button-rounded btn-block nott ls0 m-0" type="submit" value="submit">Valider le paiement</button>
                                        </form>
                                    </div>
                                <?php elseif (isset($success) && $success): ?>
                                    <div class="alert alert-success nobottommargin" role="alert">
                                       Paiement validé ! Redirection vers le profil..
                                    </div>
                                <?php endif; ?>
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

