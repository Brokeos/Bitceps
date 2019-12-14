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
                    <h4>Liste des entraineurs</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($trainers as $trainer): ?>
                        <tr>
                            <td><?= $trainer->getName() ?></td>
                            <td><?= ucfirst($trainer->getCategory()) ?></td>
                            <td><a href="<?= Templater::url('admin.trainers.edit', ['id' => $trainer->getId()]) ?>" class="btn btn-primary btn-sm">Editer</a></td>
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