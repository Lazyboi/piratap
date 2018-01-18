<?php

use App\Academics;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-subject')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_subject'])) {
        Academics::deleteSubject();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_subject'])) {
            Academics::disableSubject();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_subject'])) {
            Academics::enableSubject();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_subject'])) {
        Academics::restoreSubject();
    }

    if (Form::validate(['purge_subject'])) {
        Academics::purgeSubject();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-subject')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-subject'); ?>">
                <?php Route::displayIcon('add-new-subject'); ?> <span><?php Route::displayName('add-new-subject'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Academics::displaySubjectTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
