<?php

use App\Academics;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-section')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['created', 'disabled'])) {
    if (Form::validate(['delete_section'])) {
        Academics::deleteSection();
    }

    if (Route::currentData() == 'created') {
        if (Form::validate(['disable_section'])) {
            Academics::disableSection();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_section'])) {
            Academics::enableSection();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_section'])) {
        Academics::restoreSection();
    }

    if (Form::validate(['purge_section'])) {
        Academics::purgeSection();
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
            <?php if (Route::currentData() == 'created' && Permission::can('add-new-section')): ?>
              <a class="btn bg-harvard-red btn-sm" href="<?php Route::loadURL('add-new-section'); ?>">
                <?php Route::displayIcon('add-new-section'); ?> <span><?php Route::displayName('add-new-section'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php Academics::displaySectionTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
