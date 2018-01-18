<?php

use App\Ticketing;
use LPU\Form;
use LPU\Route;

if (Form::validate(['name', 'response_time', 'color', 'add_new_priority'])) {
    Ticketing::addNewPriority();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Priority Details <span class="pull-right"><i class="fa fa-caret-down"></i></span></h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <div class="form-header">
        <?php Form::displayNotes(); ?>
      </div>
      <?php Form::displayMessage(); ?>
      <div class="form-group <?php Form::displayFieldState('name', 'state'); ?>">
        <label class="col-sm-2 control-label" for="name"><span class="text-danger">*</span> Name</label>
        <div class="col-sm-10">
          <input autocomplete="off" autofocus class="form-control" id="name" name="name" required type="text" value="<?php Form::loadFieldData('name'); ?>">
          <?php Form::displayFieldState('name', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('response_time', 'state'); ?>">
        <label class="col-sm-2 control-label" for="response-time">
          <span class="text-danger">*</span> Response Time
          <div class="hint">(Format is Hour:Minute:Second)</div>
        </label>
        <div class="col-sm-10">
          <div class="input-group">
            <input autocomplete="off" class="form-control" timepicker id="response-time" name="response_time" required type="text" value="<?php Form::loadFieldData('response_time'); ?>">
            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
          </div>
          <?php Form::displayFieldState('response_time', 'message'); ?>
        </div>
      </div>
      <div class="form-group <?php Form::displayFieldState('color', 'state'); ?>">
        <label class="col-sm-2 control-label" for="color"><span class="text-danger">*</span> Color</label>
        <div class="col-sm-10">
          <input autocomplete="off" class="form-control" id="color" name="color" required type="color" value="<?php Form::loadFieldData('color'); ?>">
          <?php Form::displayFieldState('color', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
        <i class="fa fa-angle-double-left"></i> Back
      </a>
      <button class="btn bg-olive pull-right" name="add_new_priority" type="submit">Save New Priority</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
