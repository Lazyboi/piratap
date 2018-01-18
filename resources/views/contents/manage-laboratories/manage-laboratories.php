<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-laboratory')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_laboratory'])) {
        ComputerLaboratory::deleteLaboratory();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_laboratory'])) {
            ComputerLaboratory::disableLaboratory();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_laboratory'])) {
            ComputerLaboratory::enableLaboratory();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_laboratory'])) {
        ComputerLaboratory::restoreLaboratory();
    }

    if (Form::validate(['purge_laboratory'])) {
        ComputerLaboratory::purgeLaboratory();
    }
}

?>
<div class="row">
  <div class="col-xs-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <?php Route::displayTabs(); ?>
      </ul>
      <div class="tab-content">
        <?php Form::displayMessage(); ?>
        <div class="tab-pane active">
          <div class="tab-toolbox">
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-laboratory')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-new-laboratory'); ?>">
                <?php Route::displayIcon('add-new-laboratory'); ?> <span><?php Route::displayName('add-new-laboratory'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php ComputerLaboratory::displayLaboratoryTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
