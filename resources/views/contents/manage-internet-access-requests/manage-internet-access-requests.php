<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-internet-access-request')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (Route::currentData() == 'created-pending' || Route::currentData() == 'for-approval' || Route::currentData() == 'approved' || Route::currentData() == 'disapproved' || Route::currentData() == 'disabled') {
    if (Form::validate(['delete_internet_access_request'])) {
        ComputerLaboratory::deleteInternetAccessRequest();
    }

    if (Route::currentData() == 'created-pending' || Route::currentData() == 'for-approval' || Route::currentData() == 'approved' || Route::currentData() == 'disapproved') {
        if (Form::validate(['disable_internet_access_request'])) {
            ComputerLaboratory::disableInternetAccessRequest();
        }
    }

    if (Route::currentData() == 'for-approval') {
        if (Form::validate(['approve_internet_access_request'])) {
            ComputerLaboratory::approveInternetAccessRequest();
        }

        if (Form::validate(['disapprove_internet_access_request'])) {
            ComputerLaboratory::disapproveInternetAccessRequest();
        }
    }

    if (Route::currentData() == 'approved') {
        if (Form::validate(['cancel_approval_internet_access_request'])) {
            ComputerLaboratory::cancelApprovalInternetAccessRequest();
        }
    }

    if (Route::currentData() == 'disapproved') {
        if (Form::validate(['cancel_disapproval_internet_access_request'])) {
            ComputerLaboratory::cancelDisapprovalInternetAccessRequest();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_internet_access_request'])) {
            ComputerLaboratory::enableInternetAccessRequest();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_internet_access_request'])) {
        ComputerLaboratory::restoreInternetAccessRequest();
    }

    if (Form::validate(['purge_internet_access_request'])) {
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
            <?php if (Route::currentData() == 'created-pending' && Permission::can('add-new-internet-access-request')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-new-internet-access-request'); ?>">
                <?php Route::displayIcon('add-new-internet-access-request'); ?> <span><?php Route::displayName('add-new-internet-access-request'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php ComputerLaboratory::displayInternetAccessRequestTable(Route::currentData()); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
