<?php

use App\Academics;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-class')) {
    Route::go('dashboard');
}

Route::validateTabs();

    if (Form::validate(['delete_class'])) {
        Academics::deleteClass();
    }

// if (in_array(Route::currentData(), ['pending', 'imported', 'finalized', 'disabled'])) {
//     if (Form::validate(['delete_class'])) {
//         Academics::deleteClass();
//     }
//
//     if (Route::currentData() == 'imported') {
//         if (Form::validate(['clear_class'])) {
//             Academics::clearClass();
//         }
//
//         if (Form::validate(['finalize_class'])) {
//             Academics::finalizeClass();
//         }
//     }
//
//     if (Route::currentData() == 'finalized') {
//         if (Form::validate(['unfinalize_class'])) {
//             Academics::unfinalizeClass();
//         }
//     }
//
//     if (Route::currentData() == 'created-pending' || Route::currentData() == 'imported' || Route::currentData() == 'finalized') {
//         if (Form::validate(['disable_class'])) {
//             Academics::disableClass();
//         }
//     }
//
//     if (Route::currentData() == 'disabled') {
//         if (Form::validate(['enable_class'])) {
//             Academics::enableClass();
//         }
//     }
// }
//
// if (Route::currentData() == 'deleted') {
//     if (Form::validate(['restore_class'])) {
//         Academics::restoreClass();
//     }
//
//     if (Form::validate(['purge_class'])) {
//         Academics::purgeClass();
//     }
// }

?>
<div class="row">
  <div class="col-xs-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <?php Route::displayTabs(Route::current(), Route::currentData()); ?>
      </ul>
      <div class="tab-content">
        <?php Form::displayMessage(); ?>
        <div class="tab-pane active">
          <div class="tab-toolbox">
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-class')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-class'); ?>">
                <?php Route::displayIcon('add-new-class'); ?> <span><?php Route::displayName('add-new-class'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Academics::displayClassTable(Route::currentData()); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
