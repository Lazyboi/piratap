<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-my-internet-access-request')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (Route::currentData() == 'pending' || Route::currentData() == 'processed' || Route::currentData() == 'approved' || Route::currentData() == 'disapproved' || Route::currentData() == 'disabled') {
    if (Form::validate(['delete_my_internet_access_request'])) {
        ComputerLaboratory::deleteMyInternetAccessRequest();
    }

    if (Route::currentData() == 'pending' || Route::currentData() == 'processed' || Route::currentData() == 'approved' || Route::currentData() == 'disapproved') {
        if (Form::validate(['disable_my_internet_access_request'])) {
            ComputerLaboratory::disableMyInternetAccessRequest();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_my_internet_access_request'])) {
            ComputerLaboratory::enableMyInternetAccessRequest();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_my_internet_access_request'])) {
        ComputerLaboratory::restoreMyInternetAccessRequest();
    }

    if (Form::validate(['purge_my_internet_access_request'])) {
        ComputerLaboratory::purgeInternetAccessRequest();
    }
}

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
            <?php if (Route::currentData() == 'pending' && Permission::can('add-my-new-internet-access-request')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-my-new-internet-access-request'); ?>">
                <?php Route::displayIcon('add-my-new-internet-access-request'); ?> <span><?php Route::displayName('add-my-new-internet-access-request'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php ComputerLaboratory::displayMyInternetAccessRequestTable(Route::currentData()); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
