<?php

use App\UserManagement;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-permission')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (Route::currentData() == 'enabled') {
    if (Form::validate(['disable_permission'])) {
        UserManagement::disablePermission();
    }
}

if (Route::currentData() == 'disabled') {
    if (Form::validate(['enable_permission'])) {
        UserManagement::enablePermission();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-permission')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-permission'); ?>">
                <?php Route::displayIcon('add-new-permission'); ?> <span><?php Route::displayName('add-new-permission'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php UserManagement::displayPermissionTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
