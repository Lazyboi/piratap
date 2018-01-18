<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Route;

ComputerLaboratory::validateIncidentReport();

if (Form::validate(['findings', 'action_taken', 'process_incident_report'])) {
    ComputerLaboratory::processIncidentReport();
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
      <div class="form-group <?php Form::displayFieldState('findings', 'state'); ?>">
        <label class="col-sm-2 control-label" for="findings"><span class="text-danger">*</span> Findings</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="findings" name="findings" required rows="8"><?php echo Form::loadFieldData('findings'); ?></textarea>
          <?php Form::displayFieldState('findings', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('action_taken', 'state'); ?>">
        <label class="col-sm-2 control-label" for="action-taken"><span class="text-danger">*</span> Action Taken</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="action-taken" name="action_taken" required rows="8"><?php echo Form::loadFieldData('action_taken'); ?></textarea>
          <?php Form::displayFieldState('action_taken', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
      <button class="btn bg-olive pull-right" name="process_incident_report" type="submit">Process Incident Report</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
