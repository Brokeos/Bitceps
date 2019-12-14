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
                        <h4>Edition du tarif <?= $tarif->getName() ?></h4>
                        <?php if (isset($errors) && count($errors) > 0): ?>
                            <div class="center">
                                <?php foreach($errors as $error): ?>
                                    <div class="badge badge-pill badge-danger"><?= $error ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= Templater::url('admin.tarifs.edit.post', ['id' => $tarif->getId()]) ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?= $tarif->getName() ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">Prix</label>
                                    <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="<?= $tarif->getPrice() ?>" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
Templater::render("footer.html.php", $parameters);
?>