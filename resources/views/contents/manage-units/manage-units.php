<?php

use App\Ticketing;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-unit')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_unit'])) {
        Ticketing::deleteUnit();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_unit'])) {
            Ticketing::disableUnit();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_unit'])) {
            Ticketing::enableUnit();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_unit'])) {
        Ticketing::restoreUnit();
    }

    if (Form::validate(['purge_unit'])) {
        Ticketing::purgeUnit();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-unit')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-new-unit'); ?>">
                <?php Route::displayIcon('add-new-unit'); ?> <span><?php Route::displayName('add-new-unit'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Ticketing::displayUnitTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
