<?php

use App\ComputerLaboratory;
use LPU\Form;
use LPU\Route;

if (Form::validate(['laboratory_class', 'purpose', 'activity_date', 'submit_my_internet_access_request'])) {
    ComputerLaboratory::submitMyInternetAccessRequest();
} else {
    ComputerLaboratory::getMyInternetRequestData();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Internet Access Request Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div>
      <?php if (Form::checkState(true)): ?>
        <div class="alert <?php Form::displayState('state', true); ?> alert-dismissible fade in">
          <button class="close" data-dismiss="alert" type="button">[Close]</button>
          <?php Form::displayState('title', true); ?>
          <?php Form::displayState('description', true); ?>
        </div>
      <?php endif; ?>
      <div class="form-group <?php Form::displayFieldState('laboratory_class', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Laboratory Class</label>
        <div class="col-sm-10">
          <select class="form-control" name="laboratory_class" required size="10">
            <?php ComputerLaboratory::displayAssignedClassSelect(Form::getFieldData('laboratory_class')); ?>
          </select>
          <?php Form::displayFieldState('laboratory_class', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('purpose', 'state'); ?>">
        <label class="col-sm-2 control-label" for="purpose"><span class="text-danger">*</span> Purpose</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="purpose" name="purpose" required><?php Form::loadFieldData('purpose'); ?></textarea>
          <?php Form::displayFieldState('purpose', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('activity_date', 'state'); ?>">
        <label class="col-sm-2 control-label" for="activity-date"><span class="text-danger">*</span> Activity Date</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="activity-date" name="activity_date" type="text" required value="<?php Form::loadFieldData('activity_date'); ?>">
          <?php Form::displayFieldState('activity_date', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
      <button class="btn bg-olive pull-right" name="submit_my_internet_access_request" type="submit">Submit Request</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
