<?php

use App\UserManagement;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-department')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_department'])) {
        UserManagement::deleteDepartment();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_department'])) {
            UserManagement::disableDepartment();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_department'])) {
            UserManagement::enableDepartment();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_department'])) {
        UserManagement::restoreDepartment();
    }

    if (Form::validate(['purge_department'])) {
        UserManagement::purgeDepartment();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-department')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-department'); ?>">
                <?php Route::displayIcon('add-new-department'); ?> <span><?php Route::displayName('add-new-department'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php UserManagement::displayDepartmentTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
