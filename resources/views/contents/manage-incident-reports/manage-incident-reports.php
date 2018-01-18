<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Permission;
use LPU\Route;

if (!Permission::can('view-incident-report')) {
    Route::go('dashboard');
}

Route::validateTabs();

if (Route::currentData() == 'pending' || Route::currentData() == 'processed' || Route::currentData() == 'disabled') {
    if (Form::validate(['delete_incident_report'])) {
        ComputerLaboratory::deleteIncidentReport();
    }

    if (Route::currentData() == 'pending' || Route::currentData() == 'processed') {
        if (Form::validate(['disable_incident_report'])) {
            ComputerLaboratory::disableIncidentReport();
        }
    }

    if (Route::currentData() == 'pending') {
        if (Form::validate(['acknowledge_incident_report'])) {
            ComputerLaboratory::acknowledgeIncidentReport();
        }
    }

    if (Route::currentData() == 'processed') {
        if (Form::validate(['deprocess_incident_report'])) {
            ComputerLaboratory::deprocessIncidentReport();
        }
    }

    if (Route::currentData() == 'disabled') {
        if (Form::validate(['enable_incident_report'])) {
            ComputerLaboratory::enableIncidentReport();
        }
    }
}

if (Route::currentData() == 'deleted') {
    if (Form::validate(['restore_incident_report'])) {
        ComputerLaboratory::restoreIncidentReport();
    }

    if (Form::validate(['purge_incident_report'])) {
        ComputerLaboratory::purgeIncidentReport();
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
            <?php if (Route::currentData() == 'pending' && Permission::can('add-new-incident-report')): ?>
              <a class="btn bg-olive btn-sm" href="<?php Route::loadURL('add-new-incident-report'); ?>">
                <?php Route::displayIcon('add-new-incident-report'); ?> <span><?php Route::displayName('add-new-incident-report'); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="table-responsive">
            <?php ComputerLaboratory::displayIncidentReportTable(Route::currentData()); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php Form::clearState(true);?>
