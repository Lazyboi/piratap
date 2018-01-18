<?php

use App\Ticketing;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-service')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_service'])) {
        Ticketing::deleteService();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_service'])) {
            Ticketing::disableService();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_service'])) {
            Ticketing::enableService();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_service'])) {
        Ticketing::restoreService();
    }

    if (Form::validate(['purge_service'])) {
        Ticketing::purgeService();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-service')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-new-service'); ?>">
                <?php Route::displayIcon('add-new-service'); ?> <span><?php Route::displayName('add-new-service'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Ticketing::displayServiceTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
