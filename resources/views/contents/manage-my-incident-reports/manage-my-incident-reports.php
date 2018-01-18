<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-my-incident-report')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (in_array(Route::currentData(), ['pending', 'disabled'])) {
    if (Form::validate(['delete_my_incident_report'])) {
        ComputerLaboratory::deleteMyIncidentReport();
    }

    if (Route::currentData() == 'pending') {
        if (Form::validate(['disable_my_incident_report'])) {
            ComputerLaboratory::disableMyIncidentReport();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_my_incident_report'])) {
            ComputerLaboratory::enableMyIncidentReport();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_my_incident_report'])) {
        ComputerLaboratory::restoreMyIncidentReport();
    }

    if (Form::validate(['purge_my_incident_report'])) {
        ComputerLaboratory::purgeMyIncidentReport();
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
            <?php if (Route::currentData() == 'pending' && Permission::can('add-my-new-incident-report')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-my-new-incident-report'); ?>">
                <?php Route::displayIcon('add-my-new-incident-report'); ?> <span><?php Route::displayName('add-my-new-incident-report'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php ComputerLaboratory::displayMyIncidentReportTable(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
