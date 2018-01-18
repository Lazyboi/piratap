<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-computer')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_computer'])) {
        ComputerLaboratory::deleteComputer();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_computer'])) {
            ComputerLaboratory::disableComputer();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_computer'])) {
            ComputerLaboratory::enableComputer();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_computer'])) {
        ComputerLaboratory::restoreComputer();
    }

    if (Form::validate(['purge_computer'])) {
        ComputerLaboratory::purgeComputer();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-computer')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-new-computer'); ?>">
                <?php Route::displayIcon('add-new-computer'); ?> <span><?php Route::displayName('add-new-computer'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php ComputerLaboratory::displayComputerTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
