<?php

use App\Templater;

?>
<div class="sidebar nobottommargin clearfix col-md-3">
    <div class="sidebar-widgets-wrap">
        <div class="widget widget_links clearfix">
            <h4>Administration</h4>
            <ul>
                <li><a href="<?= Templater::url('admin.trainers') ?>"><div><i class="icon-chevron-right"></i> Entraineurs</div></a></li>
                <li><a href="<?= Templater::url('admin.planning') ?>"><div><i class="icon-chevron-right"></i> Planning</div></a></li>
                <li><a href="<?= Templater::url('admin.tarifs') ?>"><div><i class="icon-chevron-right"></i> Tarifs</div></a></li>
                <li><a href="<?= Templater::url('admin.users') ?>"><div><i class="icon-chevron-right"></i> Utilisateurs</div></a></li>
                <li><a href="<?= Templater::url('admin.participations') ?>"><div><i class="icon-chevron-right"></i> Participations</div></a></li>
            </ul>
        </div>
    </div>
</div>