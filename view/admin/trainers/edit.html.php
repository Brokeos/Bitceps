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
                        <h4>Edition de <?= $trainer->getName() ?></h4>
                        <?php if (isset($errors) && count($errors) > 0): ?>
                            <div class="center">
                                <?php foreach($errors as $error): ?>
                                    <div class="badge badge-pill badge-danger"><?= $error ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= Templater::url('admin.trainers.edit.post', ['id' => $trainer->getId()])?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?= $trainer->getName() ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="category">Catégorie</label>
                                    <input type="text" class="form-control" id="category" name="category" placeholder="Catégorie" value="<?= $trainer->getCategory() ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="color">Couleur</label>
                                    <input type="color" class="form-control" id="color" name="color" value="<?= $trainer->getColor() ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="picture">Image</label>
                                    <input type="file" class="form-control" id="picture" name="picture" placeholder="Image">
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