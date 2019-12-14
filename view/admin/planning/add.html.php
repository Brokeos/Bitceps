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
                        <h4>Ajout d'un cours</h4>
                        <?php if (isset($errors) && count($errors) > 0): ?>
                            <div class="center">
                                <?php foreach($errors as $error): ?>
                                    <div class="badge badge-pill badge-danger"><?= $error ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= Templater::url('admin.planning.add.post') ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="day">Jour</label>
                                    <select  class="form-control" name="day" id="day" required>
                                        <?php foreach($days as $day): ?>
                                            <option value="<?= $day ?>"><?= ucfirst($day) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="trainer_id">Entraineur</label>
                                    <select  class="form-control" name="trainer_id" id="trainer_id" required>
                                        <?php foreach($trainers as $trainer): ?>
                                            <option value="<?= $trainer->getId() ?>"><?= $trainer->getName() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="hourStart">Heure de début</label>
                                    <input type="time" class="form-control" id="hourStart" name="hourStart" placeholder="00:00" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hourEnd">Heure de fin</label>
                                    <input type="time" class="form-control" id="hourEnd" name="hourEnd" placeholder="00:00" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
Templater::render("footer.html.php", $parameters);
?>