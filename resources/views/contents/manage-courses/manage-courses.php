<?php

use App\Academics;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-course')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_course'])) {
        Academics::deleteCourse();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_course'])) {
            Academics::disableCourse();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_course'])) {
            Academics::enableCourse();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_course'])) {
        Academics::restoreCourse();
    }

    if (Form::validate(['purge_course'])) {
        Academics::purgeCourse();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-course')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-course'); ?>">
                <?php Route::displayIcon('add-new-course'); ?> <span><?php Route::displayName('add-new-course'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Academics::displayCourseTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
