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
                        <h4>Editer un cours</h4>
                        <?php if (isset($errors) && count($errors) > 0): ?>
                            <div class="center">
                                <?php foreach($errors as $error): ?>
                                    <div class="badge badge-pill badge-danger"><?= $error ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= Templater::url('admin.planning.edit.post', ['id' => $lesson->getId()]) ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?= $lesson->getName() ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?= $lesson->getDescription() ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="day">Jour</label>
                                    <select  class="form-control" name="day" id="day" value="<?= $lesson->getDay() ?>" required>
                                        <?php foreach($days as $day): ?>
                                            <option value="<?= $day ?>" <?= $day == $lesson->getDay() ? 'selected' : '' ?>><?= ucfirst($day) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="trainer_id">Entraineur</label>
                                    <select  class="form-control" name="trainer_id" id="trainer_id" required>
                                        <?php foreach($trainers as $trainer): ?>
                                            <option value="<?= $trainer->getId() ?>" <?= $trainer->getId() == $lesson->getTrainerID() ? 'selected' : '' ?>><?= $trainer->getName() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="hourStart">Heure de début</label>
                                    <input type="time" class="form-control" id="hourStart" name="hourStart" placeholder="00:00" value="<?= $lesson->getHourStart() ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hourEnd">Heure de fin</label>
                                    <input type="time" class="form-control" id="hourEnd" name="hourEnd" placeholder="00:00" value="<?= $lesson->getHourEnd() ?>" required>
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