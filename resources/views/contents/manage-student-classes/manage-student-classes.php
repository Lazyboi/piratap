<?php

use App\UserManagement;
use App\Academics;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-student-classes')) {
    Route::go('dashboard');
}

Route::validateTabs();

// if (in_array(Route::currentData(), ['created', 'disabled'])) {
//     if (Form::validate(['delete_user'])) {
//         UserManagement::deleteUser();
//     }
//
//     if (Route::currentData() == 'created') {
//         if (Form::validate(['disable_user'])) {
//             UserManagement::disableUser();
//         }
//     }
//
//     if (Route::currentData() == 'disabled') {
//         if (Form::validate(['enable_user'])) {
//             UserManagement::enableUser();
//         }
//     }
// }
//
// if (Route::currentData() == 'deleted') {
//     if (Form::validate(['restore_user'])) {
//         UserManagement::restoreUser();
//     }
//
//     if (Form::validate(['purge_user'])) {
//         UserManagement::purgeUser();
//     }
// }

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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-student-classes')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-student-classes'); ?>">
                <?php Route::displayIcon('add-new-student-classes'); ?> <span><?php Route::displayName('add-new-student-classes'); ?>
              </a>
            <?php endif; ?>

            <?php if (Route::currentData() == 'created' && Permission::can('import-user')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('import-user'); ?>">
                <?php Route::displayIcon('import-user'); ?> <span><?php Route::displayName('import-user'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Academics::displayStudentClassesTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
