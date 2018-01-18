<?php

use App\UserManagement;
use App\Academics;
use LPU\Form;
use LPU\Route;

if (Form::validate(['name', 'add_new_student_classes'])) {
    Academics::addNewStudentClasses();
}

?>
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Role Details</h3>
  </div>
  <form class="form-horizontal" method="POST">
    <div class="box-body">
      <?php Form::displayMessage(); ?>
      <div class="form-group <?php Form::displayFieldState('student', 'state'); ?>">
        <label class="col-sm-2 control-label" for="student"><span class="text-danger">*</span> Name</label>
        <div class="col-sm-10">
          <input autocomplete="off" autofocus class="form-control" id="student" name="student" required type="text" value="<?php Form::loadFieldData('student'); ?>">
          <?php Form::displayFieldState('student', 'message'); ?>
        </div>
      </div>

      <div class="form-group <?php Form::displayFieldState('subjects', 'state'); ?>">
        <label class="col-sm-2 control-label">
          Subject(s)
          <div class="hint">(Multiple selection is allowed)</div>
        </label>
        <div class="col-sm-10">
          <select class="form-control" multiple="multiple" name="subjects[]" size="15">
            <?php Academics::displaySubjectSelect(Form::getFieldData('subjects')); ?>
          </select>
          <?php Form::displayFieldState('subjects', 'message'); ?>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <a class="btn btn-default" href="<?php Route::loadURL(Route::getParent(Route::current())); ?>">
      Back
      </a>
      <button class="btn bg-harvard-red pull-right" name="add_new_role" type="submit">Save Student Class</button>
    </div>
  </form>
</div>
<?php Form::clearState(true);?>
