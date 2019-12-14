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
                        <h4>Tarifs</h4>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prix</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($tarifs as $tarif): ?>
                                <tr>
                                    <td><?= $tarif->getName() ?></td>
                                    <td><?= $tarif->getPrice() ?>€</td>
                                    <td><a href="<?= Templater::url('admin.tarifs.edit', ['id' => $tarif->getId()]) ?>" class="btn btn-primary btn-sm">Editer</a></td>
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