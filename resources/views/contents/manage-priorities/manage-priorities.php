<?php

use App\Ticketing;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-priority')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_priority'])) {
        Ticketing::deletePriority();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_priority'])) {
            Ticketing::disablePriority();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_priority'])) {
            Ticketing::enablePriority();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_priority'])) {
        Ticketing::restorePriority();
    }

    if (Form::validate(['purge_priority'])) {
        Ticketing::purgePriority();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-priority')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-new-priority'); ?>">
                <?php Route::displayIcon('add-new-priority'); ?> <span><?php Route::displayName('add-new-priority'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Ticketing::displayPriorityTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
