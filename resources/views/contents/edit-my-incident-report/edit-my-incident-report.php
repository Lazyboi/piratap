<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Route;

ComputerLaboratory::validateMyIncidentReport();

if (Form::validate(['date_of_incident', 'laboratory_no', 'name_of_violation_incident', 'summary_of_violation_incident', 'persons_involved', 'edit_my_incident_report'])) {
    ComputerLaboratory::editMyIncidentReport();
} else {
    ComputerLaboratory::getMyIncidentReportData();
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
          <input autocomplete="off" class="form-control" id="name-of-violation-incident" name="name_of_violation_incident" type="text" required value="<?php Form::loadFieldData('name_of_violation_incident'); ?>">
          <?php Form::displayFieldState('name_of_violation_incident', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('summary_of_violation_incident', 'state'); ?>">
        <label class="col-sm-2 control-label" for="summary-of-violation-incident"><span class="text-danger">*</span> Summary of Violation/Incident</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="summary-of-violation-incident" name="summary_of_violation_incident" required rows="8"><?php Form::loadFieldData('summary_of_violation_incident'); ?></textarea>
          <?php Form::displayFieldState('summary_of_violation_incident', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('persons_involved', 'state'); ?>">
        <label class="col-sm-2 control-label" for="persons-involved">
          <span class="text-danger">*</span> Person(s) Involved
          <div class="hint">(More than one person is allowed)</div>
        </label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" data-role="tagsinput" id="persons-involved" name="persons_involved" type="text" required value="<?php Form::loadFieldData('persons_involved'); ?>">
          <?php Form::displayFieldState('persons_involved', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('attachments', 'state'); ?>">
        <label class="col-sm-2 control-label" for="attachments">
          Attachments
          <div class="hint">(More than one attachment is allowed)</div>
        </label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" data-role="tagsinput" id="attachments" name="attachments" type="text" value="<?php Form::loadFieldData('attachments'); ?>">
          <?php Form::displayFieldState('attachments', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
      <button class="btn bg-olive pull-right" name="edit_my_incident_report" type="submit">Save Incident Report Changes</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
