<?php

use App\Academics;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-classlist')) {
    Route::go('dashboard');
}

Route::validateTabs();

// if (in_array(Route::currentData(), ['created', 'disabled'])) {
//     if (Form::validate(['delete_role'])) {
//         UserManagement::deleteRole();
//     }
//
//     if (Route::currentData() == 'created') {
//         if (Form::validate(['disable_role'])) {
//             UserManagement::disableRole();
//         }
//     }
//
//     if (Route::currentData() == 'disabled') {
//         if (Form::validate(['enable_role'])) {
//             UserManagement::enableRole();
//         }
//     }
// }
//
// if (Route::currentData() == 'deleted') {
//     if (Form::validate(['restore_role'])) {
//         UserManagement::restoreRole();
//     }
//
//     if (Form::validate(['purge_role'])) {
//         UserManagement::purgeRole();
//     }
// }

?>
<div class="row">
  <div class="col-xs-12">
    <div class="nav-tabs-custom">

      <div class="tab-content">
        <?php Form::displayMessage(); ?>
        <div class="tab-pane active">
          <div class="tab-toolbox">
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-classlist')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-classlist'); ?>">
                <?php Route::displayIcon('add-new-classlist'); ?> <span><?php Route::displayName('add-new-classlist'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Academics::displayClassListTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
