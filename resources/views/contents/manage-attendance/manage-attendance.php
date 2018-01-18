<?php

use App\Attendance;
use App\Academics;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-attendance')) {
    Route::go('dashboard');
}

Route::validateTabs();
// Attendance::validateTimeIn();

if (in_array(Route::currentData(), ['created'])) {
    if (Form::validate(['delete_attendance'])) {
        Attendance::deleteAttendance();
    }
  }
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-attendance')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-attendance'); ?>">
                <?php Route::displayIcon('add-new-attendance'); ?> <span><?php Route::displayName('add-new-attendance'); ?>
              </a>
            <?php endif; ?>

            <!-- <?php if (Route::currentData() == 'created' && Permission::can('export-faculty-attendance')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('export-faculty-attendance'); ?>">
                <?php Route::displayIcon('export-faculty-attendance'); ?> <span><?php Route::displayName('export-faculty-attendance'); ?>
              </a>
            <?php endif; ?> -->

          </div>
          <div class="table-responsive">
            <?php Attendance::displayAttendanceTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
