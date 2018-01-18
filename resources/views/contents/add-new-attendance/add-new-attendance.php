<?php

use App\Academics;
use App\Attendance;
use App\UserManagement;
use LPU\Form;
use LPU\Route;

if (Form::validate(['user', 'class', 'time_in', 'time_out', 'add-new-attendance'])) {
    Attendance::addNewAttendance();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h2 class="box-title">Attendance Details</h2>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">

      <?php Form::displayMessage(); ?>
      <!--Student Name-->
      <div class="form-group <?php Form::displayFieldState('user', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Student</label>
        <div class="col-sm-10">
          <select class="form-control" name="user" required size="10">
            <?php UserManagement::displayUserSelect(Form::getFieldData('user')); ?>
          </select>
          <?php Form::displayFieldState('user', 'message'); ?>
        </div>
      </div>

      <!--Class Name-->
      <div class="form-group <?php Form::displayFieldState('class', 'state'); ?>">
        <label class="col-sm-2 control-label"><span class="text-danger">*</span> Class</label>
        <div class="col-sm-10">
          <select class="form-control" name="class" required size="10">
            <?php Academics::displayClassSelect(Form::getFieldData('class')); ?>
          </select>
          <?php Form::displayFieldState('class', 'message'); ?>
        </div>
      </div>

      <!--Time In-->
      <div class="form-group <?php Form::displayFieldState('time_in', 'state'); ?>">
        <label class="col-sm-2 control-label">
          <span class="text-danger">*</span> Time In
        </label>
        <div class="col-sm-10">
          <div class="input-group">
            <input autocomplete="off" class="form-control" datetimepicker id="time_in" name="time_in" required type="text" value="<?php Form::loadFieldData('time_in'); ?>">
            <span class="input-group-addon"><i class="fa fa-times"></i></span>
            </div>
            <?php Form::displayFieldState('time_in', 'message'); ?>
          </div>
        </div>

        <!--Time Out-->
        <div class="form-group <?php Form::displayFieldState('time_out', 'state'); ?>">
          <label class="col-sm-2 control-label">
            Time Out
          </label>
          <div class="col-sm-10">
            <div class="input-group">
              <input autocomplete="off" class="form-control" datetimepicker id="time_out" name="time_out" required type="text" value="<?php Form::loadFieldData('time_out'); ?>">
              <span class="input-group-addon"><i class="fa fa-times"></i></span>
              </div>
              <?php Form::displayFieldState('time_out', 'message'); ?>
            </div>
          </div>



          <!--Remarks-->
          <!-- <div class="form-group <?php Form::displayFieldState('remarks', 'state'); ?>">
            <label class="col-sm-2 control-label" for="remarks">Remarks</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="remarks" name="remarks"><?php Form::loadFieldData('remarks'); ?></textarea>
              <?php Form::displayFieldState('remarks', 'message'); ?>
            </div>
          </div> -->

    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
       Go Back
      </a>
      <button class="btn bg-harvard-red pull-right" name="add-new-attendance" type="submit">Save New Attendance</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
