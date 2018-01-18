<?php

use App\ComputerLaboratory;
use LPU\Route;

ComputerLaboratory::validateMyIncidentReport();
ComputerLaboratory::loadMyIncidentReportData();

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Incident Report Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="detail">
        <div class="row detail-info">
          <div class="col-sm-12 detail-col">
            <div>
              <label>ID</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('id'); ?></div>
            </div>
            <hr>
            <div>
              <label>Date of Incident</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('incident_date'); ?></div>
            </div>
            <hr>
            <div>
              <label>Laboratory No</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('laboratory'); ?></div>
            </div>
            <hr>
            <div>
              <label>Name of Violation/Incident</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('subject'); ?></div>
            </div>
            <hr>
            <div>
              <label>Summary of Violation/Incident</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('description'); ?></div>
            </div>
            <hr>
            <div>
              <label>Person(s) Involved</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('persons_involved'); ?></div>
            </div>
            <hr>
            <div>
              <label>Attachment(s)</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('attachments'); ?></div>
            </div>
            <hr>
            <div>
              <label>Reported At</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('reported_at'); ?></div>
            </div>
            <hr>
            <div>
              <label>Findings</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('findings'); ?></div>
            </div>
            <hr>
            <div>
              <label>Action Taken</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('action_taken'); ?></div>
            </div>
            <hr>
            <div>
              <label>Processed By</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('processed_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Created By</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('created_by'); ?></div>
            </div>
            <hr>
            <div>
              <label>Updated By</label>
              <div><?php ComputerLaboratory::displayMyIncidentReportData('updated_by'); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
    </div>
  </form>
</div>
