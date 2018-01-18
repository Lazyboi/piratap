<?php

use App\ComputerLaboratory;
use App\UserManagement;
use App\Preferences;
use LPU\Form;
use LPU\Route;

Route::validateTabs();

if (Route::currentData() == 'basic-details') {
    if (Form::validate(['date_of_incident', 'laboratory_no', 'name_of_violation_incident', 'summary_of_violation_incident', 'persons_involved', 'reported_at', 'reported_by', 'processed'])) {
        Form::createFieldData('date_of_incident', Form::getFieldData('date_of_incident'), true);
        Form::createFieldData('laboratory_no', Form::getFieldData('laboratory_no'), true);
        Form::createFieldData('name_of_violation_incident', Form::getFieldData('name_of_violation_incident'), true);
        Form::createFieldData('summary_of_violation_incident', Form::getFieldData('summary_of_violation_incident'), true);
        Form::createFieldData('persons_involved', Form::getFieldData('persons_involved'), true);
        Form::createFieldData('attachments', Form::getFieldData('attachments'), true);
        Form::createFieldData('reported_at', Form::getFieldData('reported_at'), true);
        Form::createFieldData('reported_by', Form::getFieldData('reported_by'), true);
        Form::createFieldData('processed', Form::getFieldData('processed'), true);

        if (Form::getFieldData('processed', Form::validate(['processed'], true)) == 1) {
            Route::go(Route::current(), 'review-and-save');
        } elseif (Form::getFieldData('processed', Form::validate(['processed'], true)) == 2) {
            Route::go(Route::current(), 'process-details');
        }
    }

    $date_of_incident = Form::getFieldData('name_of_violation_incident', Form::validate(['date_of_incident'], true));
    $laboratory_no = Form::getFieldData('summary_of_violation_incident', Form::validate(['laboratory_no'], true));
    $name_of_violation_incident = Form::getFieldData('name_of_violation_incident', Form::validate(['name_of_violation_incident'], true));
    $summary_of_violation_incident = Form::getFieldData('summary_of_violation_incident', Form::validate(['summary_of_violation_incident'], true));
    $persons_involved = Form::getFieldData('persons_involved', Form::validate(['persons_involved'], true));
    $attachments = Form::getFieldData('attachments', Form::validate(['attachments'], true));
    $reported_at = Form::getFieldData('reported_at', Form::validate(['reported_at'], true));
    $reported_by = Form::getFieldData('reported_by', Form::validate(['reported_by'], true));
    $processed = Form::getFieldData('processed', Form::validate(['processed'], true));
}

if (Route::currentData() == 'process-details') {
    if (!Form::validate(['date_of_incident', 'laboratory_no', 'name_of_violation_incident', 'summary_of_violation_incident', 'persons_involved', 'reported_at', 'reported_by', 'processed'], true)) {
        Route::go(Route::current(), 'basic-details');
    }

    if (Form::validate(['findings', 'action_taken', 'processed_at', 'processed_by'])) {
        Form::createFieldData('findings', Form::getFieldData('findings'), true);
        Form::createFieldData('action_taken', Form::getFieldData('action_taken'), true);
        Form::createFieldData('processed_at', Form::getFieldData('processed_at'), true);
        Form::createFieldData('processed_by', Form::getFieldData('processed_by'), true);

        Route::go(Route::current(), 'review-and-save');
    }

    $findings = Form::getFieldData('findings', Form::validate(['findings'], true));
    $action_taken = Form::getFieldData('action_taken', Form::validate(['action_taken'], true));
    $processed_at = Form::getFieldData('processed_at', Form::validate(['processed_at'], true));
    $processed_by = Form::getFieldData('processed_by', Form::validate(['processed_by'], true));
}

if (Route::currentData() == 'review-and-save') {
    if (!Form::validate(['processed'], true)) {
        Route::go(Route::current(), 'basic-details');
    }

    if (!Form::validate(['date_of_incident', 'laboratory_no', 'name_of_violation_incident', 'summary_of_violation_incident', 'persons_involved', 'reported_at', 'reported_by'], true)) {
        Route::go(Route::current(), 'basic-details');
    }

    if (Form::getFieldData('processed', true) == 2) {
        if (!Form::validate(['findings', 'action_taken', 'processed_at', 'processed_by'], true)) {
            Route::go(Route::current(), 'process-details');
        }
    }

    if (Form::validate(['add_new_incident_report'])) {
        ComputerLaboratory::addNewIncidentReport();
    } else {
        ComputerLaboratory::loadIncidentReportSummary();
    }
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Incident Report Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div>
      <?php Form::displayMessage(); ?>
      <?php if (Route::currentData() == 'basic-details'): ?>
        <div class="form-group <?php Form::displayFieldState('date_of_incident', 'state'); ?>">
          <label class="col-sm-2 control-label" for="date-of-incident"><span class="text-danger">*</span> Date of Incident</label>
          <div class="col-sm-10">
            <input autocomplete="off" autofocus class="form-control" datetimepicker id="date-of-incident" name="date_of_incident" required type="text" value="<?php Form::loadFieldData('date_of_incident'); ?>">
            <?php Form::displayFieldState('date_of_incident', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('laboratory_no', 'state'); ?>">
          <label class="col-sm-2 control-label"><span class="text-danger">*</span> Laboratory No</label>
          <div class="col-sm-10">
            <select class="form-control" name="laboratory_no" required size="10">
              <?php ComputerLaboratory::displayLaboratorySelect(Form::getFieldData('laboratory_no')); ?>
            </select>
            <?php Form::displayFieldState('laboratory_no', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('name_of_violation_incident', 'state'); ?>">
          <label class="col-sm-2 control-label" for="name-of-violation-incident"><span class="text-danger">*</span> Name of Violation/Incident</label>
          <div class="col-sm-10">
            <input autocomplete="off" autofocus class="form-control" id="name-of-violation-incident" name="name_of_violation_incident" type="text" required value="<?php echo $name_of_violation_incident; ?>">
            <?php Form::displayFieldState('name_of_violation_incident', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('summary_of_violation_incident', 'state'); ?>">
          <label class="col-sm-2 control-label" for="summary-of-violation-incident"><span class="text-danger">*</span> Summary of Violation/Incident</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="summary-of-violation-incident" name="summary_of_violation_incident" required rows="8"><?php echo $summary_of_violation_incident; ?></textarea>
            <?php Form::displayFieldState('summary_of_violation_incident', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('persons_involved', 'state'); ?>">
          <label class="col-sm-2 control-label" for="persons-involved">
            <span class="text-danger">*</span> Person(s) Involved
            <div class="hint">(More than one person is allowed)</div>
          </label>
          <div class="col-sm-10">
            <input autocomplete="off" class="form-control" data-role="tagsinput" id="persons-involved" name="persons_involved" type="text" required value="<?php echo $persons_involved; ?>">
            <?php Form::displayFieldState('persons_involved', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('attachments', 'state'); ?>">
          <label class="col-sm-2 control-label" for="attachments">
            Attachments
            <div class="hint">(More than one attachment is allowed)</div>
          </label>
          <div class="col-sm-10">
            <input autocomplete="off" class="form-control" data-role="tagsinput" id="attachments" name="attachments" type="text" value="<?php echo $attachments; ?>">
            <?php Form::displayFieldState('attachments', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('reported_at', 'state'); ?>">
          <label class="col-sm-2 control-label" for="reported-at">
            <span class="text-danger">*</span> Reported At
          </label>
          <div class="col-sm-10">
            <input autocomplete="off" class="form-control" datetimepicker id="reported-at" name="reported_at" type="text" value="<?php echo $reported_at; ?>">
            <?php Form::displayFieldState('reported_at', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('reported_by', 'state'); ?>">
          <label class="col-sm-2 control-label"><span class="text-danger">*</span> Reported By</label>
          <div class="col-sm-10">
            <select class="form-control" name="reported_by" required size="10">
              <?php UserManagement::displayUserSelect($reported_by); ?>
            </select>
            <?php Form::displayFieldState('reported_by', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('processed', 'state'); ?>">
          <label class="col-sm-2 control-label"><span class="text-danger">*</span> Is already processed?</label>
          <div class="col-sm-10">
            <?php Preferences::displayYesNoRadio('processed', $processed, true); ?>
            <?php Form::displayFieldState('processed', 'message'); ?>
          </div>
        </div>
      <?php endif; ?>
      <?php if (Route::currentData() == 'process-details'): ?>
        <div class="form-group <?php Form::displayFieldState('findings', 'state'); ?>">
          <label class="col-sm-2 control-label" for="findings"><span class="text-danger">*</span> Findings</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="findings" name="findings" required rows="8"><?php echo $findings; ?></textarea>
            <?php Form::displayFieldState('findings', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('action_taken', 'state'); ?>">
          <label class="col-sm-2 control-label" for="action-taken"><span class="text-danger">*</span> Action Taken</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="action-taken" name="action_taken" required rows="8"><?php echo $action_taken; ?></textarea>
            <?php Form::displayFieldState('action_taken', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('processed_at', 'state'); ?>">
          <label class="col-sm-2 control-label" for="processed-at">
            <span class="text-danger">*</span> Processed At
          </label>
          <div class="col-sm-10">
            <input autocomplete="off" class="form-control" datetimepicker id="processed-at" name="processed_at" type="text" value="<?php echo $processed_at; ?>">
            <?php Form::displayFieldState('processed_at', 'message'); ?>
          </div>
        </div>
        <div class="form-group <?php Form::displayFieldState('processed_by', 'state'); ?>">
          <label class="col-sm-2 control-label"><span class="text-danger">*</span> Processed By</label>
          <div class="col-sm-10">
            <select class="form-control" name="processed_by" required size="10">
              <?php UserManagement::displayUserSelect($processed_by); ?>
            </select>
            <?php Form::displayFieldState('processed_by', 'message'); ?>
          </div>
        </div>
      <?php endif; ?>
      <?php if (Route::currentData() == 'review-and-save'): ?>
        <div class="detail">
          <div class="row">
            <div class="col-xs-12">
              <div class="detail-title">
                Review Incident Report Summary
              </div>
            </div>
          </div>
          <div class="row detail-info">
            <div class="col-sm-12 detail-col">
              <div>
                <label>Date of Incident:</label>
                <div><?php ComputerLaboratory::displayIncidentReportSummary('date_of_incident'); ?></div>
              </div>
              <hr>
              <div>
                <label>Laboratory No:</label>
                <div><?php ComputerLaboratory::displayIncidentReportSummary('laboratory_no'); ?></div>
              </div>
              <hr>
              <div>
                <label>Name of Violation/Incident:</label>
                <div><?php ComputerLaboratory::displayIncidentReportSummary('name_of_violation_incident'); ?></div>
              </div>
              <hr>
              <div>
                <label>Summary of Violation/Incident:</label>
                <div><?php ComputerLaboratory::displayIncidentReportSummary('summary_of_violation_incident'); ?></div>
              </div>
              <hr>
              <div>
                <label>Person(s) Involved:</label>
                <div><?php ComputerLaboratory::displayIncidentReportSummary('persons_involved'); ?></div>
              </div>
              <hr>
              <div>
                <label>Attachment(s):</label>
                <div><?php ComputerLaboratory::displayIncidentReportSummary('attachments'); ?></div>
              </div>
              <hr>
              <div>
                <label>Reported By:</label>
                <div><?php ComputerLaboratory::displayIncidentReportSummary('reported_by'); ?></div>
              </div>
              <?php if (Form::getFieldData('processed', true) == 2): ?>
                <hr>
                <div>
                  <label>Findings:</label>
                  <div><?php ComputerLaboratory::displayIncidentReportSummary('findings'); ?></div>
                </div>
                <hr>
                <div>
                  <label>Action Taken:</label>
                  <div><?php ComputerLaboratory::displayIncidentReportSummary('action_taken'); ?></div>
                </div>
                <hr>
                <div>
                  <label>Processed By:</label>
                  <div><?php ComputerLaboratory::displayIncidentReportSummary('processed_by'); ?></div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="box-footer">
      <?php if (Route::currentData() == 'basic-details'): ?>
        <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
          <i class="fa fa-angle-double-left"></i> Back
        </a>
      <?php endif; ?>
      <?php if (Route::currentData() == 'process-details'): ?>
        <a class="btn btn-default" href="<?php Route::loadURL(Route::current(), 'basic-details'); ?>">
          <i class="fa fa-angle-double-left"></i> Back
        </a>
      <?php endif; ?>
      <?php if (Route::currentData() == 'review-and-save'): ?>
        <?php if (Form::getFieldData('processed', true) == 1): ?>
          <a class="btn btn-default" href="<?php Route::loadURL(Route::current(), 'basic-details'); ?>">
            <i class="fa fa-angle-double-left"></i> Back
          </a>
        <?php endif; ?>
        <?php if (Form::getFieldData('processed', true) == 2): ?>
          <a class="btn btn-default" href="<?php Route::loadURL(Route::current(), 'process-details'); ?>">
            <i class="fa fa-angle-double-left"></i> Back
          </a>
        <?php endif; ?>
      <?php endif; ?>
      <?php if (Route::currentData() != 'review-and-save'): ?>
        <button class="btn bg-olive pull-right" type="submit">Next <i class="fa fa-angle-double-right"></i></button>
      <?php endif; ?>
      <?php if (Route::currentData() == 'review-and-save'): ?>
        <button class="btn bg-olive pull-right" name="add_new_incident_report" type="submit">Save New Incident Report</button>
      <?php endif; ?>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
