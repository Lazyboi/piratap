<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Route;

if (Form::validate(['activity_date', 'laboratory_classes', 'purpose', 'submit_internet_access_request'])) {
    ComputerLaboratory::submitInternetAccessRequest();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Internet Access Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div>
      <?php Form::displayMessage(); ?>
      <div class="form-group <?php Form::displayFieldState('activity_date', 'state'); ?>">
        <label class="col-sm-2 control-label" for="activity-date"><span class="text-danger">*</span> Activity Date</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="activity-date" name="activity_date" type="text" required value="<?php Form::loadFieldData('activity_date'); ?>">
          <?php Form::displayFieldState('activity_date', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('laboratory_classes', 'state'); ?>">
        <label class="col-sm-2 control-label">
          <span class="text-danger">*</span> Laboratory Class(es)
          <div class="hint">(Multiple selection is allowed)</div>
        </label>
        <div class="col-sm-10">
          <select class="form-control" multiple name="laboratory_classes[]" required size="15">
            <?php ComputerLaboratory::displayAssignedClassSelect(Form::getFieldData('laboratory_classes')); ?>
          </select>
          <?php Form::displayFieldState('laboratory_classes', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('purpose', 'state'); ?>">
        <label class="col-sm-2 control-label" for="purpose"><span class="text-danger">*</span> Purpose</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="purpose" name="purpose" required><?php Form::loadFieldData('purpose'); ?></textarea>
          <?php Form::displayFieldState('purpose', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
      <button class="btn bg-olive pull-right" name="submit_internet_access_request" type="submit">Submit Internet Access Request</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
